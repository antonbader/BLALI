-- database_setup.sql

-- 1. Benutzer Tabelle (Admins und Vereins-Admins)
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL, -- Gehasht
    role TEXT NOT NULL DEFAULT 'verein', -- 'admin' oder 'verein'
    club_id INTEGER NULL, -- Referenz zum Verein, falls Rolle 'verein'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE SET NULL
);

-- 2. Vereine Tabelle
CREATE TABLE IF NOT EXISTS clubs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 3. Wettkämpfe (Saisons) Tabelle
CREATE TABLE IF NOT EXISTS competitions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    season TEXT NOT NULL, -- z.B. "2023/2024"
    max_rings INTEGER DEFAULT 300, -- Max Ringzahl pro Schütze (z.B. 600 für 60 Schuss)
    rounds INTEGER DEFAULT 1, -- Anzahl der Durchgänge (Hinrunde=1, Rückrunde=2)
    status TEXT DEFAULT 'geplant', -- 'geplant', 'aktiv', 'deaktiviert', 'archiviert'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. Mannschaften Tabelle
CREATE TABLE IF NOT EXISTS teams (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    club_id INTEGER NOT NULL,
    competition_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE,
    FOREIGN KEY (competition_id) REFERENCES competitions(id) ON DELETE CASCADE
);

-- 5. Schützen Tabelle
CREATE TABLE IF NOT EXISTS shooters (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    club_id INTEGER NOT NULL,
    team_id INTEGER NULL, -- Kader-Zuordnung
    status TEXT DEFAULT 'aktiv', -- 'aktiv', 'inaktiv'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE SET NULL
);

-- 6. Paarungen (Matches) Tabelle
CREATE TABLE IF NOT EXISTS matches (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    competition_id INTEGER NOT NULL,
    home_team_id INTEGER NOT NULL,
    guest_team_id INTEGER NOT NULL,
    round_number INTEGER NOT NULL, -- Spieltag/Runde
    match_date DATE NULL,
    status TEXT DEFAULT 'offen', -- 'offen', 'eingereicht', 'bestaetigt'
    home_points INTEGER DEFAULT 0, -- Matchpunkte Heim (2, 1, 0)
    guest_points INTEGER DEFAULT 0, -- Matchpunkte Gast
    home_total_rings INTEGER DEFAULT 0, -- Gesamtringe Heim
    guest_total_rings INTEGER DEFAULT 0, -- Gesamtringe Gast
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (competition_id) REFERENCES competitions(id) ON DELETE CASCADE,
    FOREIGN KEY (home_team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (guest_team_id) REFERENCES teams(id) ON DELETE CASCADE
);

-- 7. Ergebnisse (Einzel-Ergebnisse pro Schütze im Match)
CREATE TABLE IF NOT EXISTS results (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    match_id INTEGER NOT NULL,
    team_id INTEGER NOT NULL,
    shooter_id INTEGER NOT NULL,
    rings INTEGER NOT NULL,
    is_counted BOOLEAN DEFAULT 1, -- Zählt für das Mannschaftsergebnis (Top X)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (match_id) REFERENCES matches(id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (shooter_id) REFERENCES shooters(id) ON DELETE CASCADE
);

-- 8. Audit Logs
CREATE TABLE IF NOT EXISTS audit_logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NULL,
    action TEXT NOT NULL,
    details TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- 9. Rundentermine
CREATE TABLE IF NOT EXISTS round_dates (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    competition_id INTEGER NOT NULL,
    round_number INTEGER NOT NULL,
    match_date DATE NOT NULL,
    FOREIGN KEY (competition_id) REFERENCES competitions(id) ON DELETE CASCADE,
    UNIQUE(competition_id, round_number)
);

-- Indizes für Performance
CREATE INDEX IF NOT EXISTS idx_users_username ON users(username);
CREATE INDEX IF NOT EXISTS idx_teams_competition ON teams(competition_id);
CREATE INDEX IF NOT EXISTS idx_matches_competition ON matches(competition_id);
CREATE INDEX IF NOT EXISTS idx_results_match ON results(match_id);
