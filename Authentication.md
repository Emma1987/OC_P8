# Authentication

The Symfony security system is separated into two mechanisms: authentication and authorization.  

Authentication will define who the user is. Either he is not identified, and he is anonymous. Either he is identified (by an identification form or a cookie) and he is in this case an authenticated member. This process is managed by the firewall.  

The authorization will determine if a visitor has the right to access certain resources. This step comes after the firewall, and is managed by Symfony via access control.

## Define our users.

The users of our application are represented by the AppBundle: User class, which implements the UserInterface. These are Doctrine entities, represented by the username attribute.  
This information is defined in the file app/config/security.yml under the key `providers`.

To encrypt the password of our users in our database, we must define in the security file the encoder that will be used. It is found under the key `encoders`, in our case, we use the bcrypt encoder.

All our urls are managed by the firewall `main`. Under this key, we will be able to define certain parameters, such as the authentication system used, or the route to which users wishing to access a protected resource will have to be redirected.

Once the user authenticated, it is accessible in a controller via the `$this->getUser()` method or in a Twig view via the global `app.user`.

## Define if a user is authenticated

By default, Symfony security is used to define whether a user is authenticated. For this, 3 attributes are accessible:  
`IS_AUTHENTICATED_ANONYMOUSLY`: all users, even those who have not authenticated,  
`IS_AUTHENTICATED_REMEMBERED`: authenticated users, even those authenticated by the "Remember me" function,  
`IS_AUTHENTICATED_FULLY`: authenticated users during the current session.

These attributes can be used in the security.yml file to secure url patterns via the `access_control` key.  
It is also possible to use these attributes in a controller, via the `$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')` method or from a Twig view `{% if is_granted ('IS_AUTHENTICATED_FULLY')%}`

## Assign rights to users

It's possible to determine our own roles, and assign them to our users based on the rights that we want to assign them.  
The name of the role is free, however, it must always start with ROLE_ for Symfony's security to recognize it.
In our application, we can attribute to a user a ROLE_USER and / or ROLE_ADMIN, according to the rights which one wishes to grant to him.  

These roles can be used to secure url patterns (under the `access_control` key in the security.yml file), a controller action (using the `security.authorization_checker` service), or in a Twig view.

When roles are defined, it's possible to inherit roles. For that, we use the `role_hierarchy` key of the security.yml file.  
In our case, the ROLE_ADMIN will also have the ROLE_USER rights.

## More information

[All available configuration with SecurityBundle](https://symfony.com/doc/3.1/reference/configuration/security.html)  
[More information about security with Symfony](https://symfony.com/doc/3.1/security.html)
