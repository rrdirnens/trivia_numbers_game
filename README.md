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

4. Run the following command to start the Laravel Sail environment:

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

5. Once the containers are up and running, install the project dependencies:
```
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

6. Generate an application key:

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

3. Create an .env file and add the following, replacing `http://localhost` with the URL of your backend API. For example, if your backend API is running on port 8000, the URL would be `http://localhost:8000/api/trivia`.
```
VITE_LARAVEL_API_ENDPOINT=http://localhost/api/trivia
```


4. Compile and Hot-Reload for Development. NOTE: don't use a WSL 2 terminal for this step, use a regular bash terminal or Powershell. This is a [known issue](https://vitejs.dev/config/server-options.html#server-watch).

```
npm run dev
```

You will see something like: 
```
> trivia_front@0.0.0 dev
> vite

Port 5173 is in use, trying another one...

  VITE v4.2.1  ready in 1924 ms

  ➜  Local:   http://localhost:5174/
  ➜  Network: use --host to expose
  ➜  press h to show help
```

Use the local address, i.e. http://localhost:5174/ to access the app in the browser.

5. Compile and Minify for Production

```
npm run build
```
