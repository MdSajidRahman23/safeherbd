# Pusher Configuration Guide for SafeHerb SOS Alert System

## 🚨 Real-time Notifications Setup

The SafeHerb SOS Alert System uses Pusher for real-time notifications to ensure admins receive instant alerts when users send SOS requests.

## 📋 Prerequisites

1. **Pusher Account**: Create a free account at [pusher.com](https://pusher.com)
2. **Pusher App**: Create a new app in your Pusher dashboard

## ⚙️ Configuration Steps

### 1. Install Pusher (Already Done)
```bash
composer require pusher/pusher-php-server
```

### 2. Environment Variables
Add these lines to your `.env` file:

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=your_pusher_cluster
```

### 3. Get Pusher Credentials
1. Go to your Pusher dashboard
2. Select your app
3. Copy the credentials from the "App Keys" section:
   - **App ID**: `your_pusher_app_id`
   - **Key**: `your_pusher_app_key`
   - **Secret**: `your_pusher_app_secret`
   - **Cluster**: `your_pusher_cluster` (e.g., us2, eu, ap1)

### 4. Frontend Pusher Setup
The admin dashboard already includes Pusher JavaScript integration. Make sure to include your Pusher key in the frontend:

```javascript
// In admin dashboard view
Pusher.logToConsole = true;
var pusher = new Pusher('your_pusher_app_key', {
    cluster: 'your_pusher_cluster'
});
```

## 🧪 Testing Real-time Notifications

### 1. Start Laravel Server
```bash
php artisan serve
```

### 2. Start Queue Worker (for broadcasting)
```bash
php artisan queue:work
```

### 3. Test SOS Alert Creation
1. Login as a regular user
2. Click the "SEND SOS ALERT" button
3. Check admin dashboard for real-time notification

### 4. Verify Broadcasting
- Open browser developer tools (F12)
- Check console for Pusher connection logs
- Look for broadcast events in Laravel logs

## 🔧 Troubleshooting

### Common Issues:

1. **"Pusher connection failed"**
   - Check Pusher credentials in `.env`
   - Verify app is not paused in Pusher dashboard

2. **No real-time updates**
   - Ensure queue worker is running
   - Check Laravel broadcasting configuration
   - Verify Pusher JavaScript is loaded

3. **CORS errors**
   - Pusher should handle CORS automatically
   - Check if you're using HTTPS in production

### Debug Commands:
```bash
# Check broadcasting config
php artisan config:cache
php artisan config:clear

# Test broadcasting
php artisan tinker
>>> broadcast(new App\Events\SosAlertCreated(['message' => 'Test']));
```

## 📊 Monitoring

- **Pusher Dashboard**: Monitor connection counts and message volumes
- **Laravel Logs**: Check `storage/logs/laravel.log` for broadcasting errors
- **Browser Console**: Debug Pusher connection issues

## 🚀 Production Deployment

1. **Environment Variables**: Set production Pusher credentials
2. **Queue Configuration**: Use Redis or database queues for production
3. **HTTPS**: Ensure Pusher connections use secure WebSocket (wss://)
4. **Load Balancing**: Configure broadcast routing for multiple servers

## 📞 Support

If you encounter issues:
1. Check Pusher status page for outages
2. Review Laravel broadcasting documentation
3. Test with Pusher debug console in browser

---

**Note**: Real-time notifications are optional but highly recommended for emergency response systems. The system works without Pusher, but admins won't receive instant notifications.
