-- Live Show Awards voting database
-- Import this file into the MySQL database created in InfinityFree.

CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description VARCHAR(500) DEFAULT NULL,
    display_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    is_open TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS nominees (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    name VARCHAR(180) NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    display_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_nominee_category (id, category_id),
    KEY idx_nominees_category (category_id, display_order),
    CONSTRAINT fk_nominees_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS votes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    nominee_id INT UNSIGNED NOT NULL,
    voter_hash CHAR(64) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_one_vote_per_category (category_id, voter_hash),
    KEY idx_votes_nominee (nominee_id),
    CONSTRAINT fk_votes_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_votes_nominee_category
        FOREIGN KEY (nominee_id, category_id) REFERENCES nominees(id, category_id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO categories (title, slug, description, display_order) VALUES
('Artist of the Year', 'artist-of-year', 'Recognising an outstanding artist of the year.', 1),
('Song of the Year', 'song-of-year', 'Celebrating a standout song.', 2),
('Album of the Year', 'album-of-year', 'Recognising an exceptional album.', 3),
('Best Male Artist', 'best-male-artist', 'Celebrating outstanding male talent.', 4),
('Best Female Artist', 'best-female-artist', 'Celebrating outstanding female talent.', 5),
('Best Upcoming Artist', 'best-upcoming-artist', 'Recognising a rising star.', 6),
('Best Hip Hop Artist', 'best-hip-hop-artist', 'Celebrating excellence in hip hop.', 7),
('Best Amapiano Artist', 'best-amapiano-artist', 'Celebrating excellence in amapiano.', 8),
('Best Dancehall Artist', 'best-dancehall-artist', 'Celebrating excellence in dancehall.', 9),
('Best Gospel Artist', 'best-gospel-artist', 'Recognising inspirational gospel music.', 10),
('Best Music Producer', 'best-producer', 'Recognising outstanding music production.', 11),
('Best Music Video', 'best-music-video', 'Celebrating outstanding music visuals.', 12),
('Best Collaboration', 'best-collaboration', 'Recognising an exceptional collaboration.', 13),
('Best Live Performer', 'best-live-performer', 'Celebrating powerful live performances.', 14),
('Best Duo / Group', 'best-duo-group', 'Recognising an outstanding duo or group.', 15);
