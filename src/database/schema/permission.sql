create table table_permission(
	id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	id_user BIGINT NOT NULL,
	id_role BIGINT NOT NULL,
	FOREIGN KEY (id_user) REFERENCES table_user(id),
	FOREIGN KEY (id_role) REFERENCES table_user(id)
);