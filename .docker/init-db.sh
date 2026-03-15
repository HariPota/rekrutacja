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
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('WA12345', 'BMW', 'X5', 'Passenger', strftime('%s','2021-01-10 08:30:00'), strftime('%s','2021-03-15 10:20:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('KR98765', 'Volvo', 'FH16', 'Truck', strftime('%s','2020-11-20 14:45:00'), strftime('%s','2022-01-05 09:00:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('GD55443', 'Scania', 'R500', 'Truck', strftime('%s','2019-06-15 11:00:00'), strftime('%s','2021-09-20 16:30:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('PO77889', 'Audi', 'A4', 'Passenger', strftime('%s','2022-02-28 09:15:00'), strftime('%s','2022-04-10 13:45:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('WR33221', 'Solaris', 'Urbino 12', 'Bus', strftime('%s','2020-08-01 07:00:00'), strftime('%s','2021-12-01 08:30:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('LU44556', 'Volkswagen', 'Golf', 'Passenger', strftime('%s','2021-05-18 10:30:00'), strftime('%s','2021-07-22 14:00:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('SZ66778', 'DAF', 'XF', 'Truck', strftime('%s','2019-12-03 06:45:00'), strftime('%s','2022-02-14 11:15:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('KA11223', 'Ford', 'Transit', 'Bus', strftime('%s','2021-09-12 12:00:00'), strftime('%s','2022-01-18 15:30:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('BI99887', 'Renault', 'Megane', 'Passenger', strftime('%s','2020-03-25 08:00:00'), strftime('%s','2021-06-30 10:45:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('OL55667', 'Iveco', 'Daily', 'Truck', strftime('%s','2021-04-07 13:20:00'), strftime('%s','2021-11-11 09:50:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('RZ22334', 'Skoda', 'Octavia', 'Passenger', strftime('%s','2022-01-15 07:30:00'), strftime('%s','2022-05-20 12:00:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('TO88990', 'MAN', 'Lion City', 'Bus', strftime('%s','2020-07-19 10:00:00'), strftime('%s','2021-10-25 14:15:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('ZS44321', 'Peugeot', '308', 'Passenger', strftime('%s','2021-08-22 15:40:00'), strftime('%s','2022-03-01 08:20:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('EL77654', 'Mercedes', 'Actros', 'Truck', strftime('%s','2019-09-30 09:00:00'), strftime('%s','2021-05-15 16:00:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('SK33987', 'Hyundai', 'i30', 'Passenger', strftime('%s','2022-03-10 11:25:00'), strftime('%s','2022-06-18 13:50:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('RA66543', 'Volvo', '7900', 'Bus', strftime('%s','2020-01-08 06:30:00'), strftime('%s','2021-04-12 07:45:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('KI11876', 'Opel', 'Astra', 'Passenger', strftime('%s','2021-11-05 14:00:00'), strftime('%s','2022-02-28 10:30:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('CZ88123', 'Scania', 'P320', 'Truck', strftime('%s','2020-04-14 08:15:00'), strftime('%s','2021-08-09 12:40:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('PI55234', 'Fiat', '500', 'Passenger', strftime('%s','2022-04-01 10:00:00'), strftime('%s','2022-07-15 09:20:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('OP99345', 'Mercedes', 'Citaro', 'Bus', strftime('%s','2019-11-22 07:50:00'), strftime('%s','2021-02-17 11:10:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('NS22456', 'Kia', 'Ceed', 'Passenger', strftime('%s','2021-06-28 13:30:00'), strftime('%s','2021-12-20 15:55:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('TK77567', 'DAF', 'CF', 'Truck', strftime('%s','2020-02-11 09:45:00'), strftime('%s','2021-07-03 08:00:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('ZG44678', 'Citroen', 'C4', 'Passenger', strftime('%s','2022-05-05 11:00:00'), strftime('%s','2022-08-30 14:25:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('LE88789', 'Solaris', 'Alpino', 'Bus', strftime('%s','2020-10-17 06:00:00'), strftime('%s','2021-11-28 10:35:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('PT33890', 'Mazda', '3', 'Passenger', strftime('%s','2021-03-09 15:20:00'), strftime('%s','2021-09-14 12:50:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('JG66901', 'Renault', 'Master', 'Truck', strftime('%s','2019-08-25 08:30:00'), strftime('%s','2021-01-30 16:15:00'));
    INSERT INTO vehicles (registration_number, brand, model, \"type\", created_at, updated_at) VALUES ('SW11012', 'Seat', 'Leon', 'Passenger', strftime('%s','2022-06-12 10:45:00'), strftime('%s','2022-09-25 09:00:00'));
    "
    echo "SQLite database initialized with 30 records."
else
    echo "SQLite database already exists, skipping init."
fi
