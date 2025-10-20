# Inventory API

## Description
A logistics management API built with Phalcon PHP, designed to handle orders, clients, products, and stock. It provides a RESTful structure for integration with logistics.

## 💻 Prerequisites
* **Docker** `^24.0`
* **Docker Compose** `^2.0`

## 🐋 Installation

1. Build the Docker images
```bash
docker compose build
```

2. Start the containers
```bash
docker compose up -d
```

3. Access the application container
```bash
docker exec -it phalcon_app bash
```

4. Run the migrations
```bash
phalcon migration run
```

5. Access the application
```bash
# Open your browser and navigate to:
http://localhost:8000
```