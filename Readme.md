<p align="center"><img src="http://www.markurion.eu/wp-content/uploads/2017/01/unnamed.gif"></p>

## Time Table Scraper
This tool should download a new timetable for selected course, and it will create and link with current timetable.

## Reason 
Original timetable website is just awful. To access the timetable you need to click 20 times and enter one screech.
There should be just a link to every course code, so you can get the current one. 
But There is not. So im in the process of creating one. 

## How this will work ? 
1. The original timetable website is on some sort of javascript. So im taking the content of that using python with Selenium. 
2. The php framework will send commands using Symfony Subprocess trough args to python script which will scrape the desired timetable only when ned. And it will report back the result's.
3. Then website will create a link that will always display working timetable, and the statistics. 


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

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
