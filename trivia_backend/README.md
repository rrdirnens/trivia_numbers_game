## Project Setup (Laravel Sail)
This project uses Laravel Sail for an easy-to-use development environment. Follow these steps to get the project up and running on your machine, regardless of whether you're using macOS, Windows, or Linux.

Prerequisites
Ensure Docker Desktop is installed on your machine. Download it from the [official Docker website](https://www.docker.com/products/docker-desktop)

For Windows users, enable WSL 2 and install a Linux distribution following [these instructions](https://docs.microsoft.com/en-us/windows/wsl/install).


### Installation
1. After cloning the repository to your local machine, make sure you're in the right directory.

```
cd trivia-backend
```

2. Copy the .env.example file to create a new .env file.

```
cp .env.example .env
```
Note: Update the .env file with the appropriate settings if necessary.

3. Run the following command to start the Laravel Sail environment:

```
./vendor/bin/sail up
```
Alternatively, you can configure an alias for the command to make your life a little easier
```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
sail up
```
If you don't have the sail command available, you can use Docker Compose directly:
```
docker-compose up -d
```

4. Once the containers are up and running, install the project dependencies:
```
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

5. Generate an application key:

```
./vendor/bin/sail artisan key:generate
```
Access the application in your web browser at http://localhost/api/trivia which should return a JSON response with the trivia question, answer options, and the correct answer.

6. To see the Trivia Game frontend, follow the instructions in the README.md file in the trivia_front directory.
