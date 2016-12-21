#Requirements for Manual Installation
1. PHP 7
2. Apache
3. MySQL ( or PostgreSQL. It should work, but I havent tried it.)

#Vagrant Installation
1. Clone the repository and navigate into it.
2. Install vagrant
3. While in the repository, run `vagrant up` to download the prebuilt vagrant box
4. When the vagrant box has been provisioned and is running, enter `localhost:8080` into your web browser.
5. If there are any environment variables you need to set up, they will be shown on that page.

*You might need to set the environment variables using `SetEnv variable_name variable_value` in the apache configuration file.*