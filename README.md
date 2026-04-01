# Quotes Rest API - INF653 Midterm Project

## Author
**Jakob Schaefer**

## Overview
A REST API for quotes with PHP and PostgreSQL that managers the following.
Quotes
Authors
Categories

Supports the following HTTP methods.
GET
POST
PUT
DELETE

## Live Demo

## Tech Stack
PHP
PostgreSQL
Postman (testing)

### Quotes API
| Method | Endpoint | Description |
|--------|--------|------------|
| GET | `/api/quotes/` | Get all quotes |
| GET | `/api/quotes/?id=1` | Get single quote |
| GET | `/api/quotes/?author_id=1` | Get quotes by author |
| GET | `/api/quotes/?category_id=1` | Get quotes by category |
| POST | `/api/quotes/` | Create quote |
| PUT | `/api/quotes/` | Update quote |
| DELETE | `/api/quotes/` | Delete quote |
---

### Authors API
| Method | Endpoint |
|--------|--------|
| GET | `/api/authors/` |
| GET | `/api/authors/?id=1` |
| POST | `/api/authors/` |
| PUT | `/api/authors/` |
| DELETE | `/api/authors/` |
---

### Categories API
| Method | Endpoint |
|--------|--------|
| GET | `/api/categories/` |
| GET | `/api/categories/?id=1` |
| POST | `/api/categories/` |
| PUT | `/api/categories/` |
| DELETE | `/api/categories/` |
---

## Setup Instructions
1. Clone the repo
```bash
git clone  https://github.com/jakobschaefer21/INF653_Midterm.git
```
2. cd into INF653_Midterm
3. Create a .env file with the below
DB_HOST=localhost
DB_NAME=quotes
DB_USER=your_username
DB_PASS=your_password
4. Configure your database
authors - at least 5 authors
categories - at least 5 categories
quotes - at least 25 quotes
5. Run the project locally via XAMPP
6. Test the API via Postman
Get all quotes
Get single quote
Get quotes by author
Get quotes by category
Create quote
Update quote
Delete quote
7. Enjoy!