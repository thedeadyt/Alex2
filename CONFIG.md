# Configuration Alex²

## Authentification Admin

Les identifiants administrateur sont stockés dans le fichier `.env` pour plus de sécurité.

### Configuration

1. Copiez le fichier `.env.example` vers `.env` :
```bash
cp public/pages/.env.example public/pages/.env
```

2. Modifiez le fichier `.env` avec vos identifiants :
```env
ADMIN_USERNAME=admin
ADMIN_PASSWORD=11122005
```

### Connexion

- URL de connexion : `https://votre-domaine.com/login` (ou `/Alex2/login` en dev)
- Identifiant par défaut : `admin`
- Mot de passe par défaut : `11122005`

⚠️ **Important** : Changez le mot de passe par défaut en production !

## Configuration SMTP

Les paramètres SMTP OVH sont également dans le `.env` :
```env
OVH_SMTP_USER=contact@alex2.dev
OVH_SMTP_PASS=votre-mot-de-passe
OVH_SMTP_HOST=ssl0.ovh.net
OVH_SMTP_PORT=465
```

## Sécurité

- Le fichier `.env` est exclu de Git via `.gitignore`
- Ne commitez JAMAIS le fichier `.env` contenant vos vrais identifiants
- Utilisez `.env.example` comme template pour la documentation
