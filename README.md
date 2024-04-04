
## Project Setup

### Step 1 - Install Dependencies
```
composer install
```

### Step 2 - Make .env file and update database connection
```
cp .env.example .env
```

### Step 3 - Run Migration and Seeders
```
php artisan migrate:fresh --seed
```

### Step 4 - Serve the project
```
php artisan serve
```


## Insomnia Docs
Will include the attachment in the email!

## API Features
- Login (Sanctum)
- Register (Sanctum)
- Play
- Pause
- Shuffle
- Next
- Previous

## Models
- Playlist
- Song
- PlaylistSong (Pivot Table)
- PlaylistHistory
