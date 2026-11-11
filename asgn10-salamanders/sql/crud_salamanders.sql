-- WEB 250 asgn10 sandbox
-- Safe practice table inside the existing wnc_salamanders database.
-- This does not drop or modify the earlier salamanders/habitats/link tables.

USE wnc_salamanders;

CREATE TABLE IF NOT EXISTS crud_salamanders (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    common_name VARCHAR(120) NOT NULL,
    scientific_name VARCHAR(160) NOT NULL,
    family_name VARCHAR(120) NOT NULL,
    primary_habitat VARCHAR(200) NOT NULL,
    field_note VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_crud_salamanders_scientific_name (scientific_name),
    INDEX idx_crud_salamanders_common_name (common_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO crud_salamanders
    (common_name, scientific_name, family_name, primary_habitat, field_note)
VALUES
    ('Red-cheeked Salamander', 'Plethodon jordani', 'Plethodontidae', 'Cool high-elevation forests', 'Often associated with moist forest-floor cover in the southern Appalachians.'),
    ('Blue Ridge Two-lined Salamander', 'Eurycea wilderae', 'Plethodontidae', 'Cool mountain streams and seepages', 'A stream-associated salamander used here as a teaching record.'),
    ('Black-bellied Salamander', 'Desmognathus quadramaculatus', 'Plethodontidae', 'Rocky mountain streams', 'Frequently associated with cold, flowing water and wet rocks.'),
    ('Northern Dusky Salamander', 'Desmognathus fuscus', 'Plethodontidae', 'Stream edges, springs, and seepages', 'A useful example of a salamander tied closely to wet streamside habitat.'),
    ('Spring Salamander', 'Gyrinophilus porphyriticus', 'Plethodontidae', 'Cold springs, seeps, and mountain streams', 'A large stream salamander used as part of this CRUD practice dataset.')
ON DUPLICATE KEY UPDATE scientific_name = scientific_name;
