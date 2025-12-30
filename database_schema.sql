-- DDL Script for SPK WASPAS Database (Complete)
-- Generated for draw.io import

-- 1. Master Data Tables
CREATE TABLE golongans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    golongan VARCHAR(255) NOT NULL,
    pangkat VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE eselons (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_eselon VARCHAR(255) NOT NULL,
    level INT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE jenis_jabatans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_jenis_jabatan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE tingkat_pendidikans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    tingkat_pendidikan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE bidang_ilmus (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    bidang VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE unit_kerjas (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_unit VARCHAR(255) NOT NULL,
    parent_id BIGINT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE jurusan_pendidikans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_jurusan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE jabatan_fungsionals (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_jabatan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE jabatan_pelaksanas (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_jabatan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 2. Criteria Tables
CREATE TABLE kriterias (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    kode VARCHAR(255) NOT NULL,
    nama VARCHAR(255) NOT NULL,
    bobot DOUBLE NOT NULL,
    jenis ENUM('benefit', 'cost') NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE kriteria_nilais (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    kriteria_id BIGINT NOT NULL,
    kategori VARCHAR(255) NOT NULL,
    nilai DOUBLE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (kriteria_id) REFERENCES kriterias(id) 
);

-- 3. Core System Tables
CREATE TABLE jabatan_targets (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_jabatan VARCHAR(255) NOT NULL,
    id_eselon BIGINT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE bidang_ilmu_jabatan_target (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    jabatan_target_id BIGINT NOT NULL,
    bidang_ilmu_id BIGINT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (jabatan_target_id) REFERENCES jabatan_targets(id) ,
    FOREIGN KEY (bidang_ilmu_id) REFERENCES bidang_ilmus(id) 
);

CREATE TABLE syarat_jabatans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    eselon_id BIGINT NOT NULL,
    minimal_golongan_id BIGINT NULL,
    syarat_golongan_id BIGINT NULL, 
    minimal_pendidikan_id BIGINT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (eselon_id) REFERENCES eselons(id) ,
    FOREIGN KEY (minimal_golongan_id) REFERENCES golongans(id) ON DELETE SET NULL,
    FOREIGN KEY (syarat_golongan_id) REFERENCES golongans(id) ON DELETE SET NULL,
    FOREIGN KEY (minimal_pendidikan_id) REFERENCES tingkat_pendidikans(id) 
);

-- 4. Main Data Tables
CREATE TABLE kandidats (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nip VARCHAR(18) NOT NULL UNIQUE,
    nama VARCHAR(255) NOT NULL,
    tempat_lahir VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NULL,
    golongan_id BIGINT NULL,
    tmt_golongan DATE NULL,
    jenis_jabatan_id BIGINT NULL,
    eselon_id BIGINT NULL,
    jabatan VARCHAR(255) NOT NULL,
    tmt_jabatan DATE NULL,
    tingkat_pendidikan_id BIGINT NULL,
    jurusan VARCHAR(255) NULL,
    jurusan_pendidikan_id BIGINT NULL,
    jabatan_fungsional_id BIGINT NULL,
    jabatan_pelaksana_id BIGINT NULL,
    bidang_ilmu_id BIGINT NULL,
    unit_kerja_id BIGINT NULL,
    -- Assessment Keys
    kn_id_diklat BIGINT NULL,
    kn_id_skp BIGINT NULL,
    kn_id_penghargaan BIGINT NULL,
    kn_id_integritas BIGINT NULL,
    kn_id_potensi BIGINT NULL,
    kn_id_kompetensi BIGINT NULL,
    
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (golongan_id) REFERENCES golongans(id),
    FOREIGN KEY (jenis_jabatan_id) REFERENCES jenis_jabatans(id),
    FOREIGN KEY (eselon_id) REFERENCES eselons(id),
    FOREIGN KEY (tingkat_pendidikan_id) REFERENCES tingkat_pendidikans(id),
    FOREIGN KEY (jurusan_pendidikan_id) REFERENCES jurusan_pendidikans(id),
    FOREIGN KEY (jabatan_fungsional_id) REFERENCES jabatan_fungsionals(id),
    FOREIGN KEY (jabatan_pelaksana_id) REFERENCES jabatan_pelaksanas(id),
    FOREIGN KEY (bidang_ilmu_id) REFERENCES bidang_ilmus(id),
    FOREIGN KEY (unit_kerja_id) REFERENCES unit_kerjas(id),
    
    FOREIGN KEY (kn_id_diklat) REFERENCES kriteria_nilais(id) ON DELETE SET NULL,
    FOREIGN KEY (kn_id_skp) REFERENCES kriteria_nilais(id) ON DELETE SET NULL,
    FOREIGN KEY (kn_id_penghargaan) REFERENCES kriteria_nilais(id) ON DELETE SET NULL,
    FOREIGN KEY (kn_id_integritas) REFERENCES kriteria_nilais(id) ON DELETE SET NULL,
    FOREIGN KEY (kn_id_potensi) REFERENCES kriteria_nilais(id) ON DELETE SET NULL,
    FOREIGN KEY (kn_id_kompetensi) REFERENCES kriteria_nilais(id) ON DELETE SET NULL
);

-- 5. Assessment Result Tables
CREATE TABLE nilais (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    kandidat_id BIGINT NOT NULL,
    kriteria_id BIGINT NOT NULL,
    nilai DOUBLE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (kandidat_id) REFERENCES kandidats(id) ,
    FOREIGN KEY (kriteria_id) REFERENCES kriterias(id) 
);

CREATE TABLE waspas_nilais (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    jabatan_target_id BIGINT NOT NULL,
    kandidats_id BIGINT NOT NULL,
    pangkat DOUBLE NULL,
    masa_jabatan DOUBLE NULL,
    tingkat_pendidikan DOUBLE NULL,
    diklat DOUBLE NULL,
    skp DOUBLE NULL,
    penghargaan DOUBLE NULL,
    hukdis DOUBLE NULL,
    potensi DOUBLE NULL,
    kompetensi DOUBLE NULL,
    bidang_ilmu DOUBLE NULL,
    wsm DOUBLE NOT NULL,
    wpm DOUBLE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (jabatan_target_id) REFERENCES jabatan_targets(id) ,
    FOREIGN KEY (kandidats_id) REFERENCES kandidats(id) ,
    UNIQUE (jabatan_target_id, kandidats_id)
);

-- 6. User & Permissions (Spatie)
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE roles (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE (name, guard_name)
);

CREATE TABLE permissions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE (name, guard_name)
);

CREATE TABLE model_has_permissions (
    permission_id BIGINT NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT NOT NULL,
    PRIMARY KEY (permission_id, model_id, model_type),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) 
);

CREATE TABLE model_has_roles (
    role_id BIGINT NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT NOT NULL,
    PRIMARY KEY (role_id, model_id, model_type),
    FOREIGN KEY (role_id) REFERENCES roles(id) 
);

CREATE TABLE role_has_permissions (
    permission_id BIGINT NOT NULL,
    role_id BIGINT NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ,
    FOREIGN KEY (role_id) REFERENCES roles(id) 
);

-- 7. Menus
CREATE TABLE menus (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    menu_name VARCHAR(255) NOT NULL,
    route VARCHAR(255) NULL,
    icon VARCHAR(255) NULL,
    parent_id BIGINT NULL,
    `order` INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (parent_id) REFERENCES menus(id) 
);

CREATE TABLE menu_role (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    menu_id BIGINT NOT NULL,
    role_id BIGINT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE (menu_id, role_id),
    FOREIGN KEY (menu_id) REFERENCES menus(id) ,
    FOREIGN KEY (role_id) REFERENCES roles(id) 
);
