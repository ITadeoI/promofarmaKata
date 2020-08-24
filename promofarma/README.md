# Kata Promofarma - Shopping Cart
<p align="center"><img src="http://imgfz.com/i/Yt2gIPA.jpeg" width="600"></p>


### Challenge
Promofarma is a marketplace that operates with different sellers that offer their products to be sold from Promofarma. This implies that a product can be sold by one or several sellers at different prices. Therefore, in our system we have to trace the selection of the product-seller once the user adds a product to the Shopping Cart and once the transaction ends.

## Implement Shopping Cart API:
- User is Unique
- Add & Delete Seller
- Add & Delete Products linked to Seller
- Add & Delete products to cart
- Delete the entire cart
- Increase & Decrease the number of units of a product (0 means deleted)
- Get the total amount of the cart
- Remove a product from the cart
- Confirm Cart (commit to buy)

## Installing and starting the application

#### How to install
- 1.Clone the repository  
```bash
git clone https://gitlab.com/alex.garcia1/alejandro.tadeo.git
```
- 2.From Laradock Directory
```bash
sudo docker-compose up -d nginx mysql
```
- 3.Inside Laradock directory: this command shows you the containers status.
```bash
docker ps
```
You should see the container running, it looks like this:
<p align="center"><img src="http://imgfz.com/i/B2MTo54.png" width="700"></p>

- 4.From Promofarma directory: 

```bash
php artisan serve
```

Now, go the browser an text: localhost:8000
<p align="center"><img src="http://imgfz.com/i/I25uqYU.png" width="700"></p>

- 5.Fist of all to use the application, the aplication needs to be seeder correctly the database:

```bash
php artisan migrate:refresh
```
- 6.After create all the table, this command trigger fake data with factories.

```bash
php artisan db:seed
```
- 7.Then, the application needs to generate the Laravel Password Grant

```bash
php artisan passport:install
``` 
- 8.I strongly recommend you to use Postman(import the file oauth & shopping cart), to generate the token. 

<p align="center"><img src="http://imgfz.com/i/cGFTEf7.png" width="700"></p>

- 9.Substitute the client_secret with the password grant generated above on the variable {{auth}} in Postman.

<p align="center"><img src="http://imgfz.com/i/q7sjMke.png" width="700"></p>

- 10.That's all! enjoy my solution to the Promofarma's Kata

## API Documentation

**[Postman](https://www.postman.com/)** 
 - Example using postman: [ShoppingCart_Promofarma_Kata.postman_collection.json]
 
 <p align="center"><img src="https://i.ibb.co/NpkC6B7/Selection-069.png" width="700"></p>
 
- Also, By terminal you can type php artisan route:list you will see all of them more clearly.
 <p align="center"><img src="http://imgfz.com/i/8XODaG5.png" width="700"></p>
 
## Built With

  * [GitLab](https://gitlab.com/) - DevOps platform,
  * [Laravel](https://laravel.com/) - Web Application Framework
  * [Laradock](https://laradock.io/) - PHP development environment for Docker
  * [Composer](https://getcomposer.org/doc/) - Dependency management
  * [Docker](https://docs.docker.com/) - OS-level virtualization (PaaS)
  * [Postman](https://www.getpostman.com/) - API Client for testing 
  
