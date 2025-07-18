# Alert System Usage Guide

This document explains how to use the new alert system in the Laravel application.

## Overview

The alert system provides a consistent way to display success, error, warning, and info messages throughout the application. It includes both server-side (Blade) and client-side (JavaScript) implementations.

## Server-Side Alerts (Blade)

### Using the Alert Component

The main way to display alerts is using the `x-backend.layouts.components.alert` component:

```blade
{{-- Success Alert --}}
<x-backend.layouts.components.alert type="success" message="Operation completed successfully!" />

{{-- Error Alert --}}
<x-backend.layouts.components.alert type="error" message="Something went wrong!" />

{{-- Warning Alert --}}
<x-backend.layouts.components.alert type="warning" message="Please check your input." />

{{-- Info Alert --}}
<x-backend.layouts.components.alert type="info" message="Here's some information." />
```

### Using Session Messages

For session-based alerts (like after form submissions), use this pattern:

```blade
<div class="alert-message">
    @if(session('success'))
        <x-backend.layouts.components.alert type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <x-backend.layouts.components.alert type="error" :message="session('error')" />
    @endif

    @if(session('warning'))
        <x-backend.layouts.components.alert type="warning" :message="session('warning')" />
    @endif

    @if(session('info'))
        <x-backend.layouts.components.alert type="info" :message="session('info')" />
    @endif
</div>
```

### Using Blade Directives

You can also use the custom Blade directives:

```blade
@alertSuccess('Operation completed successfully!')
@alertError('Something went wrong!')
@alertWarning('Please check your input.')
@alertInfo('Here\'s some information.')
```

## Client-Side Alerts (JavaScript)

### Using the showMessage Function

In JavaScript, you can show alerts using the `showMessage` function:

```javascript
// Success message
showMessage('Operation completed successfully!', 'success');

// Error message
showMessage('Something went wrong!', 'error');

// Warning message
showMessage('Please check your input.', 'warning');

// Info message
showMessage('Here\'s some information.', 'info');
```

### Example Usage in AJAX Calls

```javascript
async function performAction() {
    try {
        const response = await fetch('/api/action', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            showMessage(result.message || 'Action completed successfully!', 'success');
        } else {
            showMessage(result.message || 'An error occurred!', 'error');
        }
    } catch (error) {
        showMessage('Network error occurred!', 'error');
    }
}
```

## Alert Types

The system supports the following alert types:

- **success**: Green alert with checkmark icon
- **error**: Red alert with warning icon
- **warning**: Yellow alert with information icon
- **info**: Blue alert with information icon
- **primary**: Primary colored alert
- **secondary**: Secondary colored alert

## Alert Properties

The alert component accepts the following properties:

- `type`: The alert type (success, error, warning, info, primary, secondary)
- `message`: The message to display
- `dismissible`: Whether the alert can be dismissed (default: true)
- `id`: Custom ID for the alert (auto-generated if not provided)

## Styling

Alerts use Tailwind CSS classes and are styled consistently with the application's design system. They include:

- Proper spacing and padding
- Icons for each alert type
- Dismiss button with hover effects
- Auto-dismiss after 5 seconds (JavaScript only)
- Responsive design

## Best Practices

1. **Use appropriate alert types**: Use success for positive actions, error for problems, warning for cautions, and info for general information.

2. **Keep messages concise**: Alert messages should be brief and clear.

3. **Use session messages for form submissions**: When redirecting after form submission, use session messages to show the result.

4. **Use JavaScript alerts for AJAX operations**: For dynamic operations, use the JavaScript `showMessage` function.

5. **Don't overuse alerts**: Only show alerts when they provide value to the user.

## Examples

### Controller Example

```php
public function store(Request $request)
{
    try {
        // Process the request
        $item = Item::create($request->validated());
        
        return redirect()->route('items.index')
            ->with('success', 'Item created successfully!');
    } catch (Exception $e) {
        return redirect()->back()
            ->with('error', 'Failed to create item: ' . $e->getMessage())
            ->withInput();
    }
}
```

### View Example

```blade
@extends('backend.layouts.master')

@section('content')
    <div class="content">
        {{-- Alert Messages --}}
        <div class="alert-message">
            @if(session('success'))
                <x-backend.layouts.components.alert type="success" :message="session('success')" />
            @endif

            @if(session('error'))
                <x-backend.layouts.components.alert type="error" :message="session('error')" />
            @endif
        </div>

        {{-- Page Content --}}
        <div class="main-content">
            <!-- Your page content here -->
        </div>
    </div>
@endsection
```

This alert system provides a consistent, user-friendly way to display feedback throughout your application. 