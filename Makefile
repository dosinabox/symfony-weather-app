build:
	docker compose build --no-cache

up:
	docker compose up --pull --wait -d

down:
	docker compose stop

shell:
	docker compose exec php sh
