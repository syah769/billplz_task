# Billplz Task

To see the implementation of questions 1 and 2, clone this GitHub repository.

For answers to questions 3, 4, 5, and 6, visit: https://codeshare.io/ldbXdB

## Setup Instructions

1. Clone the repository
   
2. Copy the `.env.example` file to `.env` and configure your environment variables
   
   Make sure to replace the following credentials with your own in the `.env` file:
   
   BILLPLZ_API_KEY=your_api_key
   
   BILLPLZ_COLLECTION_ID=your_collection_id
   
   BILLPLZ_X_SIGNATURE_KEY=your_x_signature_key
   
   BILLPLZ_SANDBOX=true

4. composer install
5. npm install
6. php artisan key:generate
7. php artisan migrate
8. npm run dev

## Please note that there is no database seeding provided in this project. You will need to manually register a user account to access the application's features.

