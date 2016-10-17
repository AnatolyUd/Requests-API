Requests API
===
By Anatoly Udod

About
---
Provides ability to save request info to it and get list of received requests.

Requirements
---
* PHP needs to be a minimum version of PHP 5.3.9
* JSON needs to be enabled
* MySQL (latest stable version)
* Composer Package Manager [Install Composer](http://getcomposer.org/doc/00-intro.md)

Installation
---

```
 $ git clone https://github.com/AnatolyUd/Requests-API.git 
 $ composer install
```
Edit your database parameters in app/config/parameters.yml 

~~~
 $ php app/console doctrine:database:create
 $ php app/console doctrine:schema:create
~~~

Usage
---

1. Go to http://YOUR_SITE/storerequest/ROUTE
 - For example: http://localhost/storerequest/first
2. Go to http://YOUR_SITE/getrequest?FILTERS 
 - For example: http://localhost/getrequest?route=first

#### Details
1. Implement API part that receives any kind of HTTP requests and save to DB, then generating
   simple JSON response with status of saving process and id of saved record (i.e. {‘Success’: true,
   ‘id’: 45})
   Need to save:
   * headers (Request headers);
   * body (Request body);
   * route (Route of request URI);
   * method (HTTP method of request);
   * IP (IP of client);
   * created (date and time of request);
   
   For example:
   make request to http://localhost/storeRequest/first;
   then save to db received headers, body, method, ip, current timestamp and route that
   equal to ‘first’;
   make JSON response {‘Success’: true, ‘id’: 45} or {‘Success’: false, ‘Message’: ‘[reason of
   fail]’}

2. Implent API part that returns all saved request or requests that matches filter conditions
   Method type: GET.
   Available filters:
   * id - Id of record;
   * route - Route of request;
   * method - Request method;
   * ip - Client IP;
   * last_days - count of days. filter by period: now-last_days to now;
   * search - string value. return records that contains ‘search’ string in headers or body.
   
   Filter logic: AND.
   Result response format: JSON
   For example: Call to http://localhost/getRequest/?method=POST&last_days=10&search=test
   should return POST requests that were made within 10 days and contain ‘test’ string in body or headers.


