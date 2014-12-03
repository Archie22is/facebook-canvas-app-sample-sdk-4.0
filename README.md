Facebook canvas app sample
==========================================

This is the sample code of a working canvas app that authenticates using facebook php sdk 4.0

Before using this snippet, you have to configure following variables:

```PHP
$app_id = 'XXXX';
$app_secret = 'XXXX';
$app_namespace = 'XXXX';
$app_scope = 'user_location,email';
```
###### $app_scope

When a person logs into your app via Facebook Login you can access a subset of that person's data stored on Facebook. Permissions are how you ask someone if you can access that data.

Permissions are strings that are passed along with a login request or an API call. `$app_scope` variable deals with the permissions.

Sample code has:

* ***email*** - Access to a person's primary email address.
* ***user_location*** - Provides access to a person's current city

This is just a minor portion of data you can obtain via API. For full list of possibilities read [official facebook documentation](https://developers.facebook.com/docs/facebook-login/permissions/v2.2).

###### $app_id
###### $app_secret
###### $app_namespace

These variables can be obained in the process of creating a new app in facebook development center.

###### ssl

You must provide https connection to your server, otherwise your app won't work.    
Self signed certificate will not work and app will fail silently without any warning.
