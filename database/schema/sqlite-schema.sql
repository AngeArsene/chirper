CREATE TABLE "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE INDEX "cache_expiration_index" on "cache"("expiration");
CREATE TABLE "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE INDEX "cache_locks_expiration_index" on "cache_locks"("expiration");
CREATE TABLE "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" varchar not null,
  "queue" varchar not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE INDEX "failed_jobs_connection_queue_failed_at_index" on "failed_jobs"(
  "connection",
  "queue",
  "failed_at"
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE "chirps"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "message" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  "idempotency_key" varchar,
  foreign key("user_id") references "users"("id") on delete cascade on update cascade
);
CREATE UNIQUE INDEX "chirps_idempotency_key_unique" on "chirps"(
  "idempotency_key"
);
CREATE TABLE "chirp_bookmarks"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "chirp_id" integer not null,
  "created_at" datetime not null,
  foreign key("user_id") references "users"("id") on delete cascade on update cascade,
  foreign key("chirp_id") references "chirps"("id") on delete cascade on update cascade
);
CREATE UNIQUE INDEX "chirp_bookmarks_chirp_id_user_id_unique" on "chirp_bookmarks"(
  "chirp_id",
  "user_id"
);
CREATE TABLE "chirp_comments"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "chirp_id" integer not null,
  "message" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  "idempotency_key" varchar,
  foreign key("user_id") references "users"("id") on delete cascade on update cascade,
  foreign key("chirp_id") references "chirps"("id") on delete cascade on update cascade
);
CREATE UNIQUE INDEX "chirp_comments_idempotency_key_unique" on "chirp_comments"(
  "idempotency_key"
);
CREATE TABLE "likes"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "likeable_type" varchar not null,
  "likeable_id" integer not null,
  "created_at" datetime not null,
  foreign key("user_id") references "users"("id") on delete cascade on update cascade
);
CREATE INDEX "likes_likeable_type_likeable_id_index" on "likes"(
  "likeable_type",
  "likeable_id"
);
CREATE UNIQUE INDEX "likes_user_id_likeable_id_likeable_type_unique" on "likes"(
  "user_id",
  "likeable_id",
  "likeable_type"
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2026_05_24_212845_create_chirps_table',1);
INSERT INTO migrations VALUES(5,'2026_06_17_190938_add_idempotency_key_to_chirps_table',1);
INSERT INTO migrations VALUES(6,'2026_08_22_131823_create_chirp_bookmarks_table',1);
INSERT INTO migrations VALUES(7,'2026_08_30_142337_create_chirp_comments_table',1);
INSERT INTO migrations VALUES(8,'2026_08_30_145342_add_idempotency_key_to_chirp_comments_table',1);
INSERT INTO migrations VALUES(9,'2026_09_06_202825_create_likes_table',1);
