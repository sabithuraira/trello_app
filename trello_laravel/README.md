<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About API

Hi, I have no time to set up Swagger for API Documentation, so I will describe it here:

### AUTH
- REGISTER: POST - {url}/api/register with body request (name, email, password & password_confirmation)  => return token & user information
- LOGIN: POST - {url}/api/login with body request (email & password )  => return token 

### TABLE FOR LIST/COLUMN DATA CRUD (USING BEARER TOKEN THAT YOU GET FROM LOGIN return data)
- INDEX: GET - {url}/api/column with body request 'date' and 'status' (optiona;)  => return list of column data
- STORE: POST - {url}/api/column with body request (title)  => return data that store
- UPDATE: PUT - {url}/api/column/{id} with body request (title)  => return data that update (id param is encryption id from real ID)
- SHOW: GET - {url}/api/column/{id}  => return data column (id param is encryption id from real ID)
- DESTROY: DELETE - {url}/api/column/{id}  => return message result (id param is encryption id from real ID)


### TABLE CARD DATA CRUD (USING BEARER TOKEN THAT YOU GET FROM LOGIN return data)
- INDEX: GET - {url}/api/card/{id}/list with body request 'date' and 'status' (optional)  => return list of card data (id param is encryption id from real ID)
- STORE: POST - {url}/api/card with body request (title, column_id, position, description)  => return data that store
- UPDATE: PUT - {url}/api/card/{id} with body request (title, column id, position, description)  => return data that update (id param is encryption id from real ID)
- SHOW: GET - {url}/api/card/{id}  => return data card (id param is encryption id from real ID)
- DESTROY: DELETE - {url}/api/card/{id}  => return message result (id param is encryption id from real ID)

