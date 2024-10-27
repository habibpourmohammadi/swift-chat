## Swift Chat

Swift Chat is a real-time messaging platform developed using the Laravel framework. This project leverages Laravel’s capabilities along with WebSocket technology for seamless communication. It uses the Laravel Reverb library for handling WebSocket connections on the server side and Laravel Echo for client-side interactions, enabling a smooth, responsive chat experience. The application is designed as a Single Page Application (SPA) using Laravel Livewire, with Tailwind CSS providing a modern, responsive UI.

![swift-chat](https://i.ibb.co/M8H4thj/Screenshot-2024-10-27-202812.png)

### Features

- **Real-Time Messaging**: Swift Chat offers real-time communication using WebSocket technology, ensuring messages are delivered instantly across clients.
  
- **SPA Architecture**: Built with Laravel Livewire to deliver a dynamic single-page application experience without reloading pages.
  
- **Responsive Design**: Styled with Tailwind CSS for a clean, user-friendly interface across devices.

- **Server-Client Communication**: Uses Laravel Reverb on the server and Laravel Echo on the client for efficient WebSocket communication.

### Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/habibpourmohammadi/swift-chat.git
   cd swift-chat
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   - Copy the `.env.example` file to `.env`.
     ```bash
     cp .env.example .env
     ```
   - Configure the database
     
   -  WebSocket server settings.
       ```bash
       php artisan reverb:install
       ```
  
4. **Generate a new encryption key**:
    ```bash
    php artisan key:generate
    ```

6. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

7. **Serve the Application**:
   ```bash
   php artisan serve
   ```

8. **Compile assets (including Tailwind CSS)**:
   ```bash
   npm run dev
   ```

9. **Start Rever**:
   ```bash
   php artisan reverb:start
   ```

### Technologies

- **Backend**: Laravel, Laravel Reverb for WebSocket
- **Frontend**: Laravel Echo, Livewire, Tailwind CSS
