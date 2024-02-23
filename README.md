# Table of Contents

- [Table of Contents](#table-of-contents)
- [Checklist Application with Laravel, Vue.js, and Tailwind CSS](#checklist-application-with-laravel-vuejs-and-tailwind-css)
- [Screenshots](#screenshots)
- [Enhanced Features](#enhanced-features)
- [Implemented Technologies](#implemented-technologies)
- [Prerequisites](#prerequisites)
- [Getting Started with Make](#getting-started-with-make)
  - [Makefile Commands](#makefile-commands)
  - [Installing Make](#installing-make)
    - [Linux](#linux)
    - [macOS](#macos)
    - [Windows](#windows)
- [Getting Started with Laravel Sail](#getting-started-with-laravel-sail)
    - [Default User Seeder](#default-user-seeder)
- [Sail - Docker for Laravel](#sail---docker-for-laravel)
  - [Installing Laravel Sail](#installing-laravel-sail)
  - [Starting Laravel Sail](#starting-laravel-sail)
  - [Stopping Laravel Sail](#stopping-laravel-sail)
  - [Stopping Laravel Sail](#stopping-laravel-sail-1)
  - [Creating a Sail Alias to Shorten the Command](#creating-a-sail-alias-to-shorten-the-command)
      - [Linux](#linux-1)
      - [macOS](#macos-1)
  - [Laravel Sail Commands](#laravel-sail-commands)
- [User Authentication and Data Storage](#user-authentication-and-data-storage)
- [How to Contribute](#how-to-contribute)
- [TODOs](#todos)
- [License](#license)


# Checklist Application with Laravel, Vue.js, and Tailwind CSS

This project presents a robust Checklist application, meticulously crafted using Laravel, Vue.js, and Tailwind CSS. The application is designed to cater to the needs of a wide range of users, from students to professionals, who are looking to organize their tasks efficiently.

The Checklist application is a testament to the seamless integration of Laravel's robust back-end capabilities, Vue.js's dynamic front-end features, and Tailwind CSS's utility-first approach for rapid UI development. It leverages Laravel Sail, a lightweight command-line interface for interacting with Laravel's default Docker environment, making it a breeze to set up and manage.

One of the key features of the application is its ability to create, update, and delete tasks. Users can easily add new tasks, edit existing ones, and remove completed tasks from their list. The application also supports marking tasks as completed, providing users with a sense of accomplishment and a clear view of their progress.

The application also offers advanced features like task filtering and searching, allowing users to easily manage and navigate through their tasks. Whether it's filtering tasks based on their completion status or searching for a specific task, the application provides a seamless user experience.

Moreover, the application supports user authentication, offering secure access to personal task lists. Registered users can manage their tasks securely in a database, while guest users can use local storage for a seamless experience without the need for authentication.

The application is designed with a focus on user experience, offering features like drag-and-drop for task reordering and pagination for improved performance. It also supports interactive calendar functionality, allowing users to select tasks by dates, making it a versatile tool for task management.

Checklist App is more than just a task management tool. It's a productivity companion that helps users stay organized, manage their time effectively, and keep track of their progress. Whether you're a student juggling multiple assignments, a professional managing various projects, or simply someone trying to keep track of daily chores, the Checklist application is designed to make your life easier and more organized. It's not just about getting things done; it's about getting things done in a more efficient and stress-free way. So why wait? Start your journey towards better productivity with the Checklist application today!

# Screenshots

![Checklist Screenshot](/docs/screenshots/checklist1.png)

![Checklist Screenshot](/docs/screenshots/checklist2.png)

![Checklist Screenshot](/docs/screenshots/checklist3.png)

![Checklist Screenshot](/docs/screenshots/checklist4.png)

![Checklist Screenshot](/docs/screenshots/checklist5.png)

![Checklist Screenshot](/docs/screenshots/checklist6.png)

![Checklist Screenshot](/docs/screenshots/checklist7.png)

![Checklist Screenshot](/docs/screenshots/checklist8.png)

![Checklist Screenshot](/docs/screenshots/checklist9.png)

# Enhanced Features

- **Interactive Calendar:** Users can select tasks by dates, by day, or on any day of the year, choosing months or days through an interactive calendar.
- **Guest and Registered User Functionality:** Tasks can be added as a guest user or as a registered user via email. The data for both types of profiles are stored in different types of databases - a relational database for registered users and a local database for guests.
- **Task Creation:** New tasks can be added by typing in the input field and pressing enter.
- **Task Modification:** Existing tasks can be edited by clicking on them and modifying the text.
- **Task Deletion:** Tasks can be removed by clicking on the delete button next to each item.
- **Task Completion:** Tasks can be marked as completed by clicking on the checkbox next to each item.
- **Task Reordering:** Tasks can be reordered by dragging and dropping them to a new position. Changes in order are saved automatically.
- **Task Filtering:** Tasks can be filtered based on their completion status (All, Active, Completed).
- **Task Searching:** Specific tasks can be searched for by typing in the search input field.
- **User Registration:** Users can register for an account to access the application.
- **User Login:** Registered users can log in to their accounts to manage their task lists.
- **Password Reset:** Users can request a password reset if they forget their password.
- **Task Pagination:** Tasks are paginated to improve user 

# Implemented Technologies

- **Laravel:** A PHP web application framework utilized for constructing efficient and secure web applications.
- **Vue.js:** A progressive JavaScript framework employed for crafting interactive user interfaces.
- **Tailwind CSS:** A utility-first CSS framework that facilitates quick and simple construction of custom designs.

# Prerequisites

Before you start, make sure you have Docker and Make installed on your system. You can find the official installation guides for Docker and Make on their respective websites:

- Docker: [Official Docker Installation Guide](https://docs.docker.com/get-docker/)
- Make: [GNU Make](https://www.gnu.org/software/make/)


# Getting Started with Make

Make is a powerful tool that simplifies the process of managing and automating tasks in a project. In the context of this Laravel application, Make is used to streamline the execution of common Laravel Sail commands.

While Laravel Sail provides a lightweight command-line interface for interacting with Laravel’s default Docker environment, Make takes it a step further by allowing you to define and run complex tasks with simple commands. This can significantly speed up your development workflow and make it easier to manage your Laravel application.

The Makefile included in this project contains a set of predefined commands for managing your Laravel application with Sail. These commands cover everything from starting and stopping Sail, interacting with your databases, installing dependencies, running database migrations and seeders, to compiling assets and generating an application key.

Comparatively, getting started with Laravel Sail involves using Sail’s commands directly. This is a great way to interact with Laravel’s default Docker environment, especially if you’re new to Docker. However, as your application grows and tasks become more complex, using Make can help you manage these tasks more efficiently.

Both Laravel Sail and Make offer valuable tools for managing your Laravel application. You can choose to use Laravel Sail commands directly, or you can use Make to automate these commands. The choice depends on your specific needs and how you prefer to work.

Remember, whether you choose to use Laravel Sail or Make, the goal is the same: to provide a smooth and efficient development workflow for your Laravel application. So, choose the tool that best suits your workflow and get started with building amazing applications with Laravel!


## Makefile Commands
Make provides a comprehensive set of commands for managing your Laravel application with Sail. It includes commands for installing and uninstalling the application, starting and stopping Sail, interacting with the MariaDB and MySQL databases, installing Composer and NPM dependencies, running database migrations and seeders, compiling assets, and generating an application key. Remember to replace the ./vendor/bin/sail path with the alias if you have set one up. This Makefile can be a great starting point for automating common tasks in your Laravel development workflow.

Here's a brief explanation of the commands in the Makefile:

- **install:** This command starts all Docker containers in the background using Laravel Sail.
- **uninstall:** This command stops and removes all Docker containers and volumes.
- **sailup:** This command starts all Docker containers in the background using Laravel Sail.
- **saildown:** This command stops all Docker containers.
- **mariadb:** This command allows you to interact directly with your MariaDB database.
- **mysql:** This command allows you to interact directly with your MySQL database.
- **composer-install:** This command installs all the necessary Composer dependencies.
- **npm-install:** This command installs all the necessary NPM dependencies.
- **migrate:** This command runs the database migrations.
- **db-seed:** This command seeds the database with test data.
- **npm-run-dev:** This command compiles your assets using NPM.
- **key-generate:** This command sets the `APP_KEY` environment variable in your `.env` file.

## Installing Make

The process of installing Make can vary depending on the operating system. Here's how you can do it on different systems:

### Linux

To install Make on Linux, you can use the package manager that comes with your distro.
Here's how you can install Make on Ubuntu:

```bash
sudo apt-get update
sudo apt-get install make
```

### macOS

You can also install Make on macOS using Homebrew³:

```bash
brew install make
```

### Windows

On Windows, you can install Make using the Winget package manager⁹:

```bash
winget install GnuWin32.make
```

Or, you can install Make using Chocolatey⁸:

```bash
choco install make
```

For more information on installing Make, you can refer to the [official Make documentation](https://www.gnu.org/software/make/).

# Getting Started with Laravel Sail

To run this project locally using Laravel Sail, follow these steps:

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/dororguez/checklist
   ```

2. **Navigate to the Project Directory:**

   ```bash
   cd checklist
   ```

3. **Start Laravel Sail:**

   ```bash
   ./vendor/bin/sail up
   ```

4. **Copy the `.env.example` File and Create a New `.env` File:**

   ```bash
   cp .env.example .env
   ```

5. **Generate an Application Key:**

   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. **Configure the Database Connection in the `.env` File:**

   ```env
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=checklist
   DB_USERNAME=root
   DB_PASSWORD=secret
   ```

7. **Run Database Migrations:**

   ```bash
   ./vendor/bin/sail artisan migrate
   ```

8. **Compile Assets:**

   ```bash
   ./vendor/bin/sail npm run dev
   ```

9. **Access the Application:**

   Open your browser and visit `http://localhost` to view the application.


### Default User Seeder

When seeding the database, a default user is created with the following credentials:

```php
  name = Admin
  email = admin@email.com
  password = 12345678,
```

This user can be used for initial testing and exploration of the application.

To run the database migrations and seed the database using Laravel Sail, you can use the following commands:

```bash
# Run Database Migrations
./vendor/bin/sail artisan migrate

# Seed the Database
./vendor/bin/sail artisan db:seed
```

These commands will set up your database schema and populate it with any seed data defined in your Laravel application, including the default user. Remember to replace the email and password with your own secure credentials in a production environment. 


# Sail - Docker for Laravel

Laravel Sail is a light-weight command-line interface designed to interact with Laravel's default Docker environment. It provides an excellent starting point for building a Laravel application using PHP, MySQL, and Redis, even without prior Docker experience.

## Installing Laravel Sail

To install Laravel Sail, you can use the following command:

```bash
curl -s "https://laravel.build/checklist?with=mariadb,redis,mailpit" | bash
```

This command will create a new Laravel application in a directory named "checklist". The application will be configured to use MariaDB, Redis, and Mailpit.

## Starting Laravel Sail

Once installed, you can start Laravel Sail with the following command from your terminal:

```bash
./vendor/bin/sail up
```

This command starts all of your application's Docker containers. Once the containers are active, you can access your application in a web browser at: http://localhost.

## Stopping Laravel Sail

When you're done working, you can stop Laravel Sail with the following command:

```bash
./vendor/bin/sail down
```

This command stops all of your application's Docker containers.

Laravel Sail simplifies the Docker setup process, making it a great tool for both beginners and experienced developers. It allows you to focus on developing your application without worrying about configuring your local development environment.


## Stopping Laravel Sail

When you're done working, you can stop Laravel Sail and delete the existing Docker volume data with the following command:

```bash
./vendor/bin/sail down -v
```

This command stops all of your application's Docker containers and delete the existing Docker volume data.


## Creating a Sail Alias to Shorten the Command

Creating an alias in your system can save you from typing the full path to Sail (`./vendor/bin/sail`) every time.

You can create an alias for Sail with the following command:

```bash
alias sail="bash ./vendor/bin/sail"
```

With this alias, launching Sail commands will be as quick as typing:

```bash
sail up
```

The process of creating an alias can vary depending on the operating system. Here's how you can do it on different systems:

#### Linux

On a Linux system, you generally add the alias to the `.bashrc` file. Open the file with a text editor:

```bash
nano ~/.bashrc
```

Then, add the alias at the end of the file:

```bash
alias sail="bash ./vendor/bin/sail"
```

Save and close the file. To make the alias take effect, you can either restart your terminal or source the `.bashrc` file:

```bash
source ~/.bashrc
```

#### macOS

Starting from Catalina, macOS uses the Z shell (zsh) by default. Therefore, you should add the alias to the `.zshrc` file:

```bash
nano ~/.zshrc
```

Add the alias at the end of the file:

```bash
alias sail="bash ./vendor/bin/sail"
```

Save and close the file. To make the alias take effect, you can either restart your terminal or source the `.zshrc` file:

```bash
source ~/.zshrc
```

For more information on creating command aliases in Linux, you can refer to the FAQ: [How to create a command alias in Linux](https://www.cyberciti.biz/faq/create-permanent-bash-alias-linux-unix/).

Creating an alias for Sail can significantly speed up your Laravel development workflow. It allows you to execute Sail commands quickly, improving your productivity.

## Laravel Sail Commands

Below are some of the primary Laravel Sail commands you'll use when working with a Laravel 10 application:

- **Remove All Docker Containers and Volumes:**
```bash
sail down --rmi all -v
```
This command stops and removes all Docker containers and volumes.

- **Start Laravel Sail:**
```bash
sail up -d
```
This command starts all Docker containers in the background.

- **Install Composer Dependencies:**
```bash
sail composer install
```
This command installs all the necessary Composer dependencies.

- **Refresh Database:**
```bash
sail php artisan migrate:fresh
```
This command refreshes the database and runs all database migrations from the beginning.

- **Seed Database:**
```bash
sail php artisan db:seed
```
This command seeds the database with test data.

- **Run NPM:**
```bash
sail npm run dev
```
This command compiles your assets using NPM.

- **Access Database:**
```bash
sail mariadb
```
This command allows you to interact directly with your MariaDB database.

- **Generate Application Key:**
```bash
sail php artisan key:generate
```
This command sets the `APP_KEY` environment variable in your `.env` file.

- **Run Application Test:**
```bash
sail php artisan test
```
This command run the test's application.

- **Run a Database Backup:**
```bash
sail php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
sail php artisan backup:run
```
This command run the backup.

- **Discover package:**
```bash
sail php artisan package:discover
```
This command you can discover a new package.

- **Rebuild the Database:**
```bash
sail php artisan migrate:fresh --seed
```
This command you can, in development environment, rebuild the database.

- **Clear Application Cache:**
```bash
sail php artisan cache:clear
```

- **Clear Route Cache:**
```bash
sail php artisan route:clear
```

- **Clear Configuration Cache:**
```bash
sail php artisan config:clear
```

- **Clear Compiled Views Cache:**
```bash
sail php artisan view:clear
```

# User Authentication and Data Storage

- This application leverages both database storage and local storage, contingent on the user's authentication status.
- For authenticated users, tasks items are preserved in the database, ensuring data durability and security.
- For unauthenticated users, tasks items are retained in the browser's local storage, offering a smooth experience without the necessity for authentication.

# How to Contribute

We appreciate contributions! If you're interested in enhancing this project, please adhere to the following steps:

1. Create a fork of the repository.
2. Generate a new branch (`git checkout -b new-feature/my-new-feature`).
3. Implement your changes and commit them (`git commit -am 'Implement new feature'`).
4. Upload your changes to your forked repository (`git push origin new-feature/my-new-feature`).
5. Initiate a new Pull Request.

# TODOs
    - Add a public API with autentication
    - Add Swagger and API documentation
    - Add Postman's API examples
    - Complete unit testing
    - Complete backend and frontend
    - Add more features to frontend
    - Add search and create tasks by date range
    - Add mailing events when a task is completed or added
    - Add a task alert system
    - Add OAuth Login/Register
    - Add more commands for automatization
    - Add database cache
  
    and more things that can be interesting...

# License

This project is licensed under the [MIT License](LICENSE). Feel free to use and modify the code as per your requirements.
