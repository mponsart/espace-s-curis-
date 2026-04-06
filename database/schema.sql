CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    avatar TEXT,
    role TEXT NOT NULL DEFAULT 'admin' CHECK (role IN ('admin')),
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS volunteers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    last_name TEXT NOT NULL DEFAULT '',
    first_name TEXT NOT NULL DEFAULT '',
    gender TEXT CHECK (gender IN ('female', 'male', 'other', 'prefer_not_to_say') OR gender IS NULL),
    birth_date TEXT,
    birth_place TEXT,
    nationality TEXT,
    email TEXT NOT NULL,
    address TEXT,
    postal_code TEXT,
    city TEXT,
    phone TEXT,
    emergency_name TEXT,
    emergency_phone TEXT,
    availability_notes TEXT,
    skills TEXT,
    tshirt_size TEXT,
    dietary_preferences TEXT,
    allergies TEXT,
    has_driving_license INTEGER NOT NULL DEFAULT 0 CHECK (has_driving_license IN (0, 1)),
    has_vehicle INTEGER NOT NULL DEFAULT 0 CHECK (has_vehicle IN (0, 1)),
    notes TEXT,
    token TEXT NOT NULL UNIQUE,
    token_expires_at TEXT NOT NULL,
    consent_rgpd INTEGER NOT NULL DEFAULT 0 CHECK (consent_rgpd IN (0, 1)),
    validated_at TEXT,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_volunteers_email ON volunteers (email);
CREATE INDEX IF NOT EXISTS idx_volunteers_token_expires_at ON volunteers (token_expires_at);
