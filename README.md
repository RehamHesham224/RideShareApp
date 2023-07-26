
## ِRide Share App

Application using Laravel and Pusher to Reserve a trip using a car

- Authentication Using mobile phone
    - Send Login Code into mobile using Twilio Notification
    - Depend on [Laravel Notification Channel](https://laravel-notification-channels.com/)
- There are two different ways to continue App 
    - First As A Passenger [ default user]
    - Second As A Driver [additional Information of his car and his name]
- Driver can Add information of it's Car
- Passenger can reserve a trip and add destination place 
- A trip can be created, started , accepted , end , and a driver can add location 
    - make events for every action
    - use websocket to broadcast events
