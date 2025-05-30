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


5. Install Firebase JWT in projects:

   ```bash
   composer require firebase/php-jwt 


6. Start development server:

   ```bash
   php spark serve 



7. Setting up CORS:

   ```bash
   php spark make:filter CorsFilter

   ```bash
   <?php

   namespace App\Filters;

   use CodeIgniter\Filters\FilterInterface;
   use CodeIgniter\HTTP\RequestInterface;
   use CodeIgniter\HTTP\ResponseInterface;

   class CorsFilter implements FilterInterface
   {
      public function before(RequestInterface $request, $arguments = null)
      {
         // Define allowed origins
         $allowedOrigins = [
               'http://localhost:8081',  // Your Vue.js app
               'http://localhost:3000',  // If you use different ports
               'http://127.0.0.1:8081',
               'https://yourdomain.com'  // Production domain
         ];

         $origin = $request->getHeaderLine('Origin');
         
         $response = service('response');

         // Check if origin is allowed
         if (in_array($origin, $allowedOrigins)) {
               $response->setHeader('Access-Control-Allow-Origin', $origin);
         }

         // Set CORS headers
         $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH');
         $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin');
         $response->setHeader('Access-Control-Allow-Credentials', 'true');
         $response->setHeader('Access-Control-Max-Age', '86400'); // 24 hours

         // Handle preflight OPTIONS request
         if ($request->getMethod() === 'OPTIONS') {
               return $response->setStatusCode(200);
         }

         return $request;
      }

      public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
      {
         // Nothing to do here
      }
   } 

   ```bash
   In App/config/Filters.php file
   'cors'          => \App\Filters\CorsFilter::class, // Add this line

   public array $globals = [
        'before' => [
            'cors', // Add this line
        ],
        'after' => [
            'toolbar',
        ],
    ];

    // Or apply to specific routes/groups
    public array $filters = [
        'cors' => [
            'before' => ['api/*'], // Apply only to API routes
        ],
    ];