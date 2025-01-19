# Setup environment
0. Set ENV file witth mysql connection.
1. Generate app key `php artisan key:generate`.  !important
2. Create new database with user.
```sql
CREATE DATABASE `tustable` /*!40100 COLLATE 'utf8mb4_general_ci' */;
CREATE USER 'tustable'@'localhost' IDENTIFIED BY 'tustable';
GRANT ALL PRIVILEGES ON `tustable`.* TO 'tustable'@'localhost';
FLUSH PRIVILEGES;
```
or

```sql
create database tustable;
grant all on tustable.* to tustable@localhost identified by 'tustable';\
flush privileges;
```
3. Execute `php artisan migrate`
4. Now most commands could be found under commands api.php
5. Use `php artisan api1` to get the list of all available commands.
5. Check if playwright integration works by running `php artisan api check`
   - This will run npm install under hood
   - It will check if playwright browsers are installed
   - if not it will ask to run npx playwright install
   - Then if os is missing dependencies it will ask to run sudo npx playwright install-deps
6. Then you need to fill courses list from using `php artisan api load_courses_list`
7. Now api is ready to request course to activate. ( See API USAGE set course as active)
8. Now its important to run queue deamon by `php artisan queue:work` 

---
# API Usage
See bruno preset for more details.
## Authenticate user - generate token by api
```
POST to http://localhost:8000/api/key
With body (email , password , device_name)
```
This will return the token for login

## Course
### Show all 
Returns list of all courses
```
http://localhost:8000/api/courses
With header Authorization Bearer {{token}}
```
### Show all where course is set as active
```
http://localhost:8000/api/courses/active
With header Authorization Bearer {{token}}
```
### Set course as active 
```
http://localhost:8000/api/courses/set/active
With header Authorization Bearer {{token}}
With body ( code , active )
```

## Timetable
Here you can download timetable for give course
### Download All timetables
### Download Specific timetable

---
# Dockerize help 
[Source](https://dev.to/frankalvarez/dockerize-a-laravel-11-app-4g4a)

---


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
