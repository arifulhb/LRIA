# LRIA 
##Lightspeed Reservation Integration App.

[Lightspeed](http://www.lightspeedpos.com/restaurant/restaurant-pos-system-full-screen/) is an iPad*(iOS)* Based __Point of Sales__ application for restourants. 

The App can receive reservation for its clients through iPad. Reservation to the restourant can also be made through the Lightspeed Reservation API.  This application uses the Lightspeed Reservation API to add new reservations from web.


### Configuration
To push or get any data from Lightspeed API, you need a `api_token` which you should collect from the API as well. To connect to the Lightspeed API and get `api_token`, you need to have your Lightspeed Partner *Partner Email*, *Password* and your *Company ID*. Using this informations, you'll connect to the API and get your `api_token` from their server.

In this project, we stored this informations in `tblPartner` of our LRIA MySQL database. In this table, we also `login_type` and `api_endpoint` field. During signin to the system, we pass the `login_type` as 0 OR 1 *(0 =demo server, 1= Live server)*. In `api_endpoint` we use `http://dev.posios.com:8080/PosServer/JSON-RPC` for demo and `http://sg1.posios.com:8080/PosServer/JSON-RPC` for live server. So, based on what Parameter you pass in Signin function in `Signin` controller, you'll be connected to respective server. 

Figure 1 is a screenshot of the table. ![alt Partner Table figure](http://i.imgur.com/8d0ndRW.png "Figure 1: Partner Table")

A database schema `lria_schema.sql` is given in support folder. Import the database in your MySQL server and configure the database info in `\application\confi\gconfig.php` file.

###System Requirements
* PHP 5.3
* MySQL 5.173

You must populate the `tblPartner` with atleast one row with either live or demo partner account. Otherwise, you might signin to the system, but you'll have no `api_token` to access the Lightspeed API.


#### Default Signin
When you have the system up and running, you need to singin to the system. Default __Username__ is *lria@example.com* and __Password__ is *123*.

