# 3voke Color Prediction Game

This project is a simple game where players guess the colour for upcoming period and will be rewarded on basis of results .

## How to Play

3 minutes for each period, 2 minutes and 30 seconds to order, 30 seconds to show the lottery result.
It opens all day. The total number of periods is 480.
If you spend 100 to trade, 

`JOIN GREEN:` 
   - If the result shows 1, 3, 7, or 9, you will get 190 (100 + 90).
   - If the result shows 5, you will get 145 (100 * 45).

`JOIN RED:`
  - If the result shows 2, 4, 6, or 8, you will get 190 (100 + 90).
  - If the result shows 0, you will get 145 (100 * 45).

`JOIN VIOLET:` 
   - If the result shows 0 or 5, you will get 145 (100 * 45).

`SELECT NUMBER:` 
   - If the result is the same as the number you selected, you will get 885 (100 * 8.85).

     

## Features

  Admin Panel
   - Manage Users
   - Manage UI of client panel
   - Manage payTm Merchants for payment Integration
   - Manage Vouchers
   - Manage results
   - Manage Strategies
   - Manage Withdrawls
   - Interactive UI 

## Technologies Used

- `HTML`
- `CSS/BOOTSTRAP`
- `PHP`
- `Third Party Packages` [phpModel (https://github.com/ajaz-ul-haqq/phpModel), AdminLTE (https://adminlte.io/)]

## Installation

- Clone this repo. 
- Import SQL
- Update database credentials and app_url in `autoload.php` as
  
  `const APP_URL = 'https://localhost/evoke/';`

  `const DB_HOST = 'localhost';`

  `const DB_USER = 'root';`
 
  `const DB_PASS = 'dbPassword';`
 
  `const DB_NAME = 'next';`

   `const GATEWAY_HANDLER = 'https://localhost/evoke/pg/order/paytm';`

## Usage

[Provide instructions on how to use the game. Include any commands or steps needed to run it.]

## Demo
 - will link later

## Contact

[Provide contact information for inquiries or support related to the game.]

