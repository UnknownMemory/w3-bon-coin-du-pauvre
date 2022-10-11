# w3-bon-coin-du-pauvre
## Lancer le projet

Démarrage des conteneurs

```console
docker compose up -d
```

Installation des dépendences et de la DB

```console
docker exec -it <id_du_conteneur_symfony> bash
cd html
composer i
symfony console d:d:c
symfony console d:d:m
```
