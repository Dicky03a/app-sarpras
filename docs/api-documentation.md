# Web Sarpras API Documentation

## Overview
This API provides endpoints for managing assets and borrowing requests in the Web Sarpras application.

## Authentication
Most API endpoints require authentication using Laravel Sanctum tokens. Include the token in the Authorization header as follows:

```
Authorization: Bearer {token}
```

## Available Endpoints

### User Information
- **GET** `/api/user` - Retrieve authenticated user information

### Borrowing Operations
- **POST** `/api/check-availability/{asset}` - Check if an asset is available for a given date range

## Detailed Endpoint Descriptions

### Get User Information
**Endpoint:** `GET /api/user`

**Description:** Returns the authenticated user's information.

**Headers:**
- `Authorization: Bearer {token}`
- `Accept: application/json`

**Response:**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  ...
}
```

### Check Asset Availability
**Endpoint:** `POST /api/check-availability/{asset}`

**Description:** Check if an asset is available for a given date range.

**Headers:**
- `Authorization: Bearer {token}`
- `Content-Type: application/json`
- `Accept: application/json`

**Parameters:**
- `asset` (path): Asset ID to check availability for
- `tanggal_mulai` (body): Start date in YYYY-MM-DD format
- `tanggal_selesai` (body): End date in YYYY-MM-DD format

**Request Body:**
```json
{
  "tanggal_mulai": "2023-12-01",
  "tanggal_selesai": "2023-12-05"
}
```

**Response:**
```json
{
  "available": true,
  "message": "Aset tersedia untuk periode tersebut."
}
```

## Rate Limiting
All API endpoints are rate limited to 60 requests per minute per user/IP address.

## Error Handling
API endpoints return appropriate HTTP status codes:
- `200`: Success
- `401`: Unauthorized
- `404`: Resource not found
- `422`: Validation error
- `500`: Server error

## Postman Collection
A Postman collection is available at `storage/api/WebSarpras.postman_collection.json` for easy testing of the API endpoints.