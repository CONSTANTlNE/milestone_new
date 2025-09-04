# Auto Auction System

This document describes the complete CRUD system for Auto Auction applications that has been implemented in the Laravel application.

## Overview

The Auto Auction system allows businesses to submit applications for onboarding as B2B accounts at Milestone Brokers. The system includes both frontend form submission and backend administration capabilities.

## Features

### Frontend Features
- **Comprehensive Application Form**: Multi-section form covering all business requirements
- **File Upload Support**: W9 forms, insurance certificates, and vehicle lists
- **Form Validation**: Client and server-side validation
- **Success/Error Messages**: User-friendly feedback
- **Responsive Design**: Mobile-friendly interface

### Backend Features
- **Complete CRUD Operations**: Create, Read, Update, Delete
- **Status Management**: Pending, Approved, Rejected statuses
- **Admin Notes**: Internal notes for each application
- **File Management**: View uploaded documents
- **Search & Filter**: Find applications by various criteria
- **Soft Delete**: Archive deleted applications
- **Bulk Operations**: Mass delete and restore

## Database Structure

### AutoAuction Model
The system uses the `AutoAuction` model with the following key fields:

- **Company Information**: Legal business name, DBA, business type, years in operation
- **Contact Information**: Name, title, phone, email
- **Auction Logistics**: Address, locations, auction days, lot numbers
- **Vehicle Information**: Types, transport preferences, pickup protocols
- **Billing Information**: Contact, email, payment methods
- **Documents**: W9, insurance certificate, vehicle list
- **Status Tracking**: Application status and admin notes

## Routes

### Frontend Routes
- `GET /auto-auction` - Display the application form
- `POST /auto-auction` - Submit the application

### Backend Routes
- `GET /backend/autoAuctions` - List all applications
- `GET /backend/autoAuctions/{id}` - View application details
- `GET /backend/autoAuctions/{id}/edit` - Edit application
- `PUT /backend/autoAuctions/{id}` - Update application
- `POST /backend/autoAuctions/status` - Change status
- `POST /backend/autoAuctions/delete` - Delete application
- `GET /backend/autoAuctions/trash` - View deleted applications
- `POST /backend/autoAuctions/restore` - Restore application
- `POST /backend/autoAuctions/remove` - Permanently delete

## Controllers

### Frontend Controller
- `App\Http\Controllers\Frontend\AutoAuctionController`
  - Handles form display and submission
  - Validates form data
  - Manages file uploads
  - Provides user feedback

### Backend Controller
- `App\Http\Controllers\Backend\Projects\AutoAuctionController`
  - Manages all CRUD operations
  - Handles status changes
  - Manages soft delete/restore
  - Provides admin interface

## Services

### AutoAuctionService
- `App\Services\AutoAuctionService`
  - Business logic for auto auction operations
  - Data filtering and pagination
  - Status management
  - Cache management

## Request Classes

All backend operations use dedicated request classes for validation:
- `AutoAuctionIndexRequest`
- `AutoAuctionChangeStatusRequest`
- `AutoAuctionUpdateRequest`
- `AutoAuctionDestroyRequest`
- `AutoAuctionMassDestroyRequest`
- `AutoAuctionTrashRequest`
- `AutoAuctionRestoreRequest`
- `AutoAuctionRemoveRequest`
- `AutoAuctionMassRemoveRequest`

## Views

### Frontend Views
- `resources/views/frontend/pages/auto_auction.blade.php`
  - Main application form
  - Responsive design
  - Form validation display

### Backend Views
- `resources/views/backend/autoAuctions/index.blade.php` - List all applications
- `resources/views/backend/autoAuctions/show.blade.php` - View application details
- `resources/views/backend/autoAuctions/edit.blade.php` - Edit application
- `resources/views/backend/autoAuctions/trash.blade.php` - View deleted applications

## Policies

### AutoAuctionPolicy
- `App\Policies\AutoAuctionPolicy`
  - Defines permissions for all auto auction operations
  - Integrates with Laravel's authorization system

## Database Migrations

### Main Migration
- `database/migrations/milestone/2025_01_20_000001_create_auto_auctions_table.php`
  - Creates the main auto_auctions table
  - Defines all required fields and constraints

### Additional Migrations
- `database/migrations/2025_08_24_170447_add_missing_fields_to_auto_auctions_table.php`
  - Adds missing fields (unattended_pickup, vehicle_list)
  - Converts payment_method to JSON

- `database/migrations/2025_08_24_171249_fix_payment_method_column_in_auto_auctions_table.php`
  - Fixes payment_method column constraints

## Seeder

### AutoAuctionSeeder
- `database/seeders/AutoAuctionSeeder.php`
  - Provides sample data for testing
  - Creates 3 sample applications with different statuses

## Usage

### For Users
1. Navigate to `/auto-auction`
2. Fill out the comprehensive application form
3. Upload required documents
4. Submit the application
5. Receive confirmation message

### For Administrators
1. Access the backend at `/backend/autoAuctions`
2. View all submitted applications
3. Click on individual applications to view details
4. Change status (Pending/Approved/Rejected)
5. Add admin notes
6. Manage files and documents

## Security Features

- **CSRF Protection**: All forms include CSRF tokens
- **File Validation**: Uploaded files are validated for type and size
- **Authorization**: All backend operations require proper permissions
- **Input Validation**: Comprehensive validation on all inputs
- **Soft Deletes**: Data is archived rather than permanently deleted

## File Storage

Uploaded files are stored in:
- `storage/app/public/auto_auctions/w9/` - W9 documents
- `storage/app/public/auto_auctions/insurance/` - Insurance certificates
- `storage/app/public/auto_auctions/vehicle_lists/` - Vehicle lists

## Testing

To test the system:

1. **Run migrations**: `php artisan migrate`
2. **Seed sample data**: `php artisan db:seed --class=AutoAuctionSeeder`
3. **Access frontend**: Visit `/auto-auction`
4. **Access backend**: Visit `/backend/autoAuctions`

## Customization

The system can be easily customized by:
- Modifying form fields in the migration
- Updating validation rules in request classes
- Customizing views for different styling
- Adding new status types
- Extending the service layer for additional business logic

## Support

For any issues or questions about the Auto Auction system, please refer to the Laravel documentation or contact the development team.
