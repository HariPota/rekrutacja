#!/bin/sh

DB_DIR="/var/www/html/db"
DB_FILE="${DB_DIR}/assqlite.db"

if [ ! -f "$DB_FILE" ]; then
    echo "Creating SQLite database..."
    touch "$DB_FILE"
    sqlite3 "$DB_FILE" "CREATE TABLE IF NOT EXISTS vehicles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        registration_number TEXT(16),
        brand TEXT(60),
        model TEXT(60),
        \"type\" TEXT,
        created_at INTEGER,
        updated_at INTEGER
    );
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('DW22233', 'Mercedes', 'MP-4', 'Truck', strftime('%s','2020-05-05 12:25:00'), strftime('%s','2021-06-07 15:05:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('BORQ4500', 'MAN', 'TGE', 'Bus', strftime('%s','2021-06-06 14:01:00'), strftime('%s','2021-06-06 14:01:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('DW33445', 'Toyota', 'Corolla', 'Passenger', strftime('%s','2021-07-05 10:25:00'), strftime('%s','2021-08-07 12:05:00'));
    "
    echo "SQLite database initialized with sample data."
else
    echo "SQLite database already exists, skipping init."
fi
