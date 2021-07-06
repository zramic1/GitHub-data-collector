#Zerina Ramic - Github Data Collector

For this task I created a small app that collects data from GitHub api. After data display user can edit/save it and download it as json.

On first load user is presented with homescreen and repositories tab is available when user is not authenticated. User can also log in with his GitHub account and see his followers. Same CRUD operations will be available for followers display as well.

##How to run it
I created a docker setup which makes everything easy to run.

First You need to create a GitHub OAuth application on your profile (https://github.com/settings/developers) and enter 
```GITHUB_CLIENT_ID and GITHUB_CLIENT_SECRET``` in ```src/.env```.

Please set authorization callback URL for OAuth application to ```http://localhost:8088/github/callback``` and homepage url to ```http://localhost:8088```
as those are values set in ```src/.env``` file. 

After OAuth is created and keys are set in ```src/.env``` You should run
```docker compose up -d --build``` and
```docker compose exec php php artisan migrate:fresh```.

This should run the application and set everything up to be available on ```http://localhost:8088```.

If You want to run tests please run ```docker compose exec php php artisan test```.

##Notes

I intentionally left vendor and node_modules included with project, so You don't have to preinstall anything.

I understand that this is not best practice, but I did this for convenience.

If You want to download JSON file You first need to save changes by clicking on "Apply changes" button and then "Download JSON file" button will be available to You.

That would be all from me. Good luck and have fun with this review :D.