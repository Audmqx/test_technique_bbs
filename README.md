## L'objectif

Créer un système de récupération automatique des posts d'une page Instagram. 

## Consignes : 

- Récupérer les derniers posts (donc quelques posts pas tous ceux de la page) et les afficher sur une page. 
- Cette récupération doit prendre en compte l'utilisation en production (ex : possibilité de l'utiliser le code par d'autres personnes et si un nouveau post apparaît il est bien considéré). 
- Nous nous concentrons ici surtout sur l'aspect back-end. 
- Il n'est évidemment pas nécessaire que ce soit ta propre page Instagram, tu peux prendre n'importe quelle page.


#### Technologies utilisées :
- "php": "^8.1",
- "laravel/framework": "^10.10",
- "guzzlehttp/guzzle": "^7.2",
- "pestphp/pest": "^2.6",
-  "nunomaduro/larastan": "^2.0",

----

#### Installation

`git clone`
`composer install`
`cp .env.example .env`

----


#### Configuration
L'application se repose sur 3 variables d'env :
```
INSTAGRAM_APP_ID=
INSTAGRAM_APP_SECRET=
INSTAGRAM_REDIRECT_URI=
```
La variable INSTAGRAM_REDIRECT_URI doit avoir comme uri : votre nom de domaine + `/instagram/auth`

Elle est réalisé pour utiliser l'api basic display d'Instagram ave cun compte utilisateur test au préalablement crée sur facebook business.

----

### Utilisation 

Il suffit de visiter l'endpoint `/instagram/get/user-medias` qui redirigeras vers Instagram pour obtenir un code unique.

Une fois validé le callback redirigeras autmatiquement vers la page qui affiche les posts :

![](https://awesomescreenshot.s3.amazonaws.com/image/1077776/40559725-dde061e1b5ca194a27c71d77d80b243e.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAJSCJQ2NM3XLFPVKA%2F20230607%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20230607T221517Z&X-Amz-Expires=28800&X-Amz-SignedHeaders=host&X-Amz-Signature=e341b33ab54d330e26ae4c48163cb0abf24cfdb247090f7bd821042dd188fd45)
> ↑ endpoint `/instagram/get/user-medias`