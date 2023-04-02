# Trivia Numbers Game
This is a simple trivia game that prompts the user with a "fill in the blank" type of question and gives 4 options to choose from. The questions come from numbersapi.com. 

## Project Backend/API Setup (Laravel Sail)
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

3. Run this command to install [composer dependencies](https://laravel.com/docs/10.x/sail#installing-composer-dependencies-for-existing-projects)
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

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


## Project frontend Setup (Vue 3 with Pinia in Vite)

### Recommended IDE Setup

[VSCode](https://code.visualstudio.com/) + [Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur) + [TypeScript Vue Plugin (Volar)](https://marketplace.visualstudio.com/items?itemName=Vue.vscode-typescript-vue-plugin).

### Customize configuration

See [Vite Configuration Reference](https://vitejs.dev/config/).

## Installation

1. Make sure you're in the right directory.

```
cd ../trivia_frontend
```
2. Install the project dependencies:
```
npm install
```

3. Compile and Hot-Reload for Development

```
npm run dev
```

4. Compile and Minify for Production

```
npm run build
```
