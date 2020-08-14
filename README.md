
## how to setup

- Clone GitHub repo for this project locally
- Install Composer Dependencies
- Install NPM Dependencies
- Create a copy of your .env file
- Generate an app encryption key
- Create an empty database for our application
- in the .env file, add database information to allow Laravel to connect to the database
- Migrate the database
- for the purpose of instant payment notifaction you need to turnel your application using ngrok so that you expose it to the internet




## basic functionality

- allows the donnor to inputs his/her information and amount
- captures details and loads pesa pal payment page that allows the donor to make payments
- redirect the customer to page with payment info eg reference status and tracking it
- captures the transaction record and associate with the donor
- ipn that listens for changes in transaction and update transaction accordingll

## approach in achieving the above functionality

- implement oauth on submiting donors information so that i would be able to sign it and ensure ii is safe while i embed to pesapal iframe
- i created a function that will be tracking transaction status based on merchant reference and tracking id and also only using tracking id,also i created a function that shows transaction details. this function i will be using on redirecting the donor to a page with payment information after payment has been made and also i will be using it while updating transaction on ipn 
- i created function that will be receiving data from merchant reference, tracking id  and notification from peaspal this function will used to achieve instant payment notification and update transaction status
- i created a restf api that will be posting transaction details to a third party system that will be used as admin
- i secured the api with jwt
- on configuration i have used the .env to set basic configuration like the use of secret key, base url and etc in order to use configurations in the system i created configuration in the config with arrays of all configuration from .env
