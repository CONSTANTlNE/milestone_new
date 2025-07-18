# Database Search Implementation

This document describes the search functionality implementation for the permissions index page using simple database queries instead of Laravel Scout.

## Overview

The search functionality has been simplified to use direct database queries with LIKE operators for searching across permission titles and names. This approach is more straightforward and doesn't require external search services.

## Implementation Details

### 1. Permission Model (`app/Models/Permission.php`)

The Permission model has been simplified to remove Scout dependencies:

```php
<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MultiTranslatableTrait;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasTranslations, SoftDeletes, EscapeUniCodeJson, MultiTranslatableTrait;

    public $table = 'permissions';
    protected $guard_name = 'web';

    protected $casts = [
        'title' => 'array',
    ];

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public array $translatable = [
        'title',
    ];

    public static function getNextPosition(): int
    {
        $lastPermission = self::orderBy('position', 'desc')->first();
        return $lastPermission ? $lastPermission->position + 1 : 1;
    }
}
```

### 2. Permission Service (`app/Services/PermissionService.php`)

The service now uses simple database queries for search:

```php
public function index(Request $request = null): \Illuminate\Pagination\LengthAwarePaginator
{
    // If search term is provided, use database search
    if ($request && $request->has('search') && !empty($request->search)) {
        return $this->searchWithDatabase($request);
    }
    
    // Otherwise, use regular query
    return $this->getFilteredPermissions($request);
}

private function searchWithDatabase(Request $request): \Illuminate\Pagination\LengthAwarePaginator
{
    $searchTerm = $request->search;
    $perPage = $request->per_page ?? 10;
    
    $query = Permission::query();
    
    // Search in title translations and name field
    $query->where(function ($q) use ($searchTerm) {
        $q->where('name', 'LIKE', "%{$searchTerm}%")
          ->orWhere('title->en', 'LIKE', "%{$searchTerm}%")
          ->orWhere('title->ka', 'LIKE', "%{$searchTerm}%");
    });
    
    // Apply status filter
    if ($request->has('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }
    
    // Apply sorting
    $sortColumn = $request->sort_column ?? 'id';
    $sortDirection = $request->sort_direction ?? 'desc';
    $query->orderBy($sortColumn, $sortDirection);
    
    return $query->paginate($perPage);
}
```

### 3. JavaScript Implementation (`public/js/my/table-functions.js`)

The JavaScript remains unchanged as it uses a generic server-side search approach that works with any backend implementation.

### 4. Routes (`routes/admin.php`)

The search route remains the same:

```php
Route::post('/permissions/search', [PermissionController::class, 'search'])->name('permissions.search');
```

### 5. Controller Method (`app/Http/Controllers/Backend/PermissionController.php`)

The controller method remains unchanged as it delegates to the service:

```php
public function search(Request $request): JsonResponse
{
    return $this->permissionService->search($request);
}
```

## Search Features

### 1. Multi-language Search
- Searches across English and Georgian title translations
- Searches in the permission name field
- Case-insensitive search using LIKE operators

### 2. Filtering
- Status filtering (active/inactive/all)
- Combined with search terms

### 3. Sorting
- Sort by any column (id, title, route, created_at)
- Ascending/descending order
- Applied after search and filtering

### 4. Pagination
- Configurable items per page (10, 25, 50, 100)
- Server-side pagination for performance

## Usage

### Frontend Usage

The search is triggered by:
1. Clicking the search button
2. Pressing Enter in the search input
3. Changing filters (status, sorting, etc.)

### Backend Usage

```php
// Example search request
$request = new Request([
    'search' => 'user',
    'status' => '1',
    'sort_column' => 'title',
    'sort_direction' => 'asc',
    'per_page' => 25,
    'page' => 1
]);

$permissions = $permissionService->index($request);
```

## Benefits of This Approach

1. **Simplicity**: No external dependencies or services required
2. **Performance**: Direct database queries are fast for moderate datasets
3. **Maintenance**: Easier to maintain and debug
4. **Flexibility**: Easy to customize search logic
5. **Cost**: No additional service costs

## Limitations

1. **Scalability**: May not perform well with very large datasets (100k+ records)
2. **Advanced Features**: No fuzzy matching or relevance scoring
3. **Real-time**: No real-time indexing like Scout provides

## Future Considerations

If the application grows to handle large datasets, consider:
1. Adding database indexes on searchable columns
2. Implementing full-text search using MySQL/PostgreSQL native features
3. Moving back to Scout with a different driver (Meilisearch, Elasticsearch)
4. Implementing caching for search results

## Testing

To test the search functionality:

1. Visit the permissions index page
2. Enter search terms in the search box
3. Click the search button or press Enter
4. Verify results are filtered correctly
5. Test with different filters and sorting options

The search now works with simple database queries without any external search service dependencies. 