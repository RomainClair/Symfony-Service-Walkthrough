# A simple walkthrough to explain Service in Symfony

This is a example of what a Service is Symfony can be used for

It includes branches for each step

## The context

We are exploring the idea of an e-commerce website.
We want to display to users the detail of a product.
The website uses two non-cumulative discounts :

- A loyalty program. Each user have it's own discount rate according to it's history with the website
- Discount programs. Each day can offers a discount rate.

So the prive of a product for a user depends on the product original price and the best from it's own loyalty discount rate and today's discount rate.

## Initial state - main branch

We start from a fat controler : `The index method in src/Controller/ProductController.php`

## Step 1 - using-service

Let's move the price calculation code to a PriceCalculator service
We can now introduce unit-test
Results in :

- `src/Service/PriceCalculator.php`
- `tests/PriceCalculator.php`
- `src/Controller/ProductController.php`

## Step 2 - with service dependency

Let's remove from the controller what's not needed in the controller : getting the information needed in the service only

Results in :

- `src/Service/PriceCalculator.php`
- `src/Controller/ProductController.php`

## Step 3 - service and interfaces

Introduce the idea of decoupling the Service from the Controller by using an interface using the example of the EntityManager and the EntityManagerInterface