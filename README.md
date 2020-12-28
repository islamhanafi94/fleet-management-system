## Fleet Management App

A Simple Bus booking system allownig passengers to book their ride from specific stations on a registered trip.

# content
1 - Running the project and configure dev environemnt

2 - getting authentication to use the APIs

3 - How to use the booking API



## Running The project


1 - **Getting project dependencies and packages**
run this command  
    
    composer install


2 - **Config File ( .env )**
```
    cp .example.env .env
``` 
and then edit the database credential and db name as follows:

```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=??
    DB_USERNAME=??
    DB_PASSWORD=??
```
3 - **Generate Secret Key for JWT**

run this command  
    
     php artisan jwt:secret


4 - **Load database from the given database.sql file**

run this command  
    
    mysql -u username -p fleet_system < database.sql


5- **Running the project**

    php artisan serve



## Authentication

### 1- Registeration


```http
POST localhost:8000/api/auth/register
```
## Request Body

```javascript
{
    "name" : "islam",
    "email" : "islam3@islam.com",
    "password": "123456",
    "c_password": "123456"
}
```
## Responses

```javascript
{
    "message": "User successfully registered",
    "user": {
        "name": "islam",
        "email": "islam3@islam.com",
        "updated_at": "2020-12-28T05:51:15.000000Z",
        "created_at": "2020-12-28T05:51:15.000000Z",
        "id": 2
    }
}
```
<!-- 
The `message` attribute contains a message commonly used to indicate errors or, in the case of deleting a resource, success that the resource was properly deleted.

The `success` attribute describes if the transaction was successful or not.

The `data` attribute contains any other metadata associated with the response. This will be an escaped string containing JSON data. -->

## Status Codes


| Status Code | Description | More
| :--- | :--- | :--|
| 201 | `CREATED` | when successfully create new user
| 400 | `BAD REQUEST` | When failing due to inappropriate user input or a doublicated email


### 2- Login


```http
POST localhost:8000/api/auth/login
```
## Request Body

```javascript
{
    "email" : "islam3@islam.com",
    "password": "123456",
}
```
## Responses

```javascript
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYwOTEzNTAxOCwiZXhwIjoxNjA5MTM4NjE4LCJuYmYiOjE2MDkxMzUwMTgsImp0aSI6InVCWGxvYmljanJQdkNHYnYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQW2qKQeslvQMuWXWOA5V0nE5ik-jbvwi4OGtFkquIGQQ" ,
   
   "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        "id": 1,
        "name": "islam",
        "email": "islam2@islam.com",
        "email_verified_at": null,
    }
}
```
 
The `access_token` attribute contains the jwt for authenticate user for other requests.

**Add the `access_token` to request header as a `bearer` token**

----------

### 3- Getting Available Seats


```http
POST localhost:8000/api/user/seats
```
## Request Body

```javascript
{
    "trip_id": "1",
    "from": "3",  // station_id
    "to" : "5"    // station_id
}
```
## Responses

```javascript
[
    {
        "id": 3,
        "code": "S3"
    },
    {
        "id": 4,
        "code": "S4"
    },
    {
        "id": 5,
        "code": "S5"
    }
]
```
 
----------


### 3- Booking a seat in trip


```http
POST localhost:8000/api/user/book
```
## Request Body

```javascript
{
    "trip_id": "1",
    "from": "3",
    "to" : "5",
    "seat_id" : "3"
}
```
## Responses

```javascript
{
    "id": "3",
    "code": "S3",
    "trip_id": "1",
    "empty_at_station": "5"
}
```

in case the requested seat is not available 

```javascript

{
    "error": "Invalid Seat"
}
```