# Calorie Tracker API

A simple **Laravel + Docker** API for simulating user calorie tracking via Telegram IDs.

This backend provides endpoints to register meals, view daily summaries, and analyze weekly stats — all running entirely inside Docker.

---

## Features

Register meals linked to a user’s Telegram ID  
Auto-create users if they don’t exist  
Retrieve daily calorie summaries  
View weekly statistics  
Fully Dockerized (PHP + MySQL + phpMyAdmin)  
Includes PHPUnit feature tests  

---

##  Tech Stack

| Component | Technology |
|------------|-------------|
| Backend | Laravel 10 (PHP 8.1) |
| Database | MySQL 8 |
| Tools | Docker, Docker Compose |
| Admin UI | phpMyAdmin |
| Testing | PHPUnit (Laravel Test Suite) |

---

##  Setup Instructions

### 1 Clone the repository
```bash
git clone https://github.com/MaliheHa93/Calories_Backend.git
cd calorie-backend
