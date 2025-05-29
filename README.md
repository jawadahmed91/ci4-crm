# CodeIgniter 4 CRM Project

A simple CRM system built using CodeIgniter 4 with:
- Authentication (Login/Logout)
- Customers CRUD
- Sales Team CRUD
- Suppliers CRUD
- Database migrations & seeders

## Features

- Modular structure
- Clean UI-ready views
- Easy to extend

## Setup Instructions

1. Clone the repo:

   ```bash
   git clone https://github.com/your-username/ci4-crm.git 

2. Install dependencies:

   ```bash
   composer install 

3. Set up database and update .env accordingly:

4. Run migrations and seeders:

   ```bash
   php spark migrate
   php spark db:seed MainSeeder

4. Start development server:

   ```bash
   php spark serve 