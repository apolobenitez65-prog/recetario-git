# Cómo aportar

## Qué necesitás instalado

- **Git** — obligatorio
- Una cuenta de **GitHub**
- Un editor de texto (VS Code, Sublime, el que uses)
- **XAMPP** — opcional, solo si querés validar y ver la página en tu máquina

## 1. Fork

Botón **Fork** arriba a la derecha. Te queda una copia en
`tu-usuario/recetario-git`.

## 2. Cloná tu fork

```bash
git clone https://github.com/TU-USUARIO/recetario-git.git
cd recetario-git
git remote add upstream https://github.com/mds2-utn-formosa/recetario-git.git
git remote -v
```

`origin` es tu fork. `upstream` es el repo original.

## 3. Rama

```bash
git switch -c comando/tu-usuario
```

Nunca trabajes sobre `main`. Tu `main` es el espejo del upstream.

## 4. Tu aporte

Creá `comandos/tu-usuario.json` con esta forma exacta:

```json
{
  "comando": "git switch -c",
  "categoria": "ramas",
  "que_hace": "Crea una rama nueva y te para encima de ella.",
  "ejemplo": "git switch -c feature/login",
  "cuidado": "Si ya existe la rama falla. Sin -c solo cambia a una existente.",
  "autor": "tu-usuario"
}
```

Categorías válidas: `basico`, `ramas`, `remoto`, `historia`, `deshacer`, `tags`,
`inspeccion`.

Agregá también tu línea en la sección **Colaboradores** del README.

## 5. Validar en tu máquina (opcional)

Si tenés XAMPP, podés revisar tu aporte antes de subirlo:

```bash
php scripts/validar.php
```

Si no lo tenés, no pasa nada: el pipeline valida igual cuando abrís el Pull
Request. Ver [XAMPP.md](XAMPP.md) si `php` no te funciona desde la terminal.

## 6. Commit y push

```bash
git add comandos/tu-usuario.json README.md
git commit -m "Agrega git switch -c al recetario"
git push origin comando/tu-usuario
```

## 7. Pull Request

GitHub te ofrece el botón **Compare & pull request**. Verificá que apunte de
`tu-usuario:comando/tu-usuario` hacia `ORG:main`.

En la descripción escribí `closes #N` con el número de tu issue.

## 8. Mantené el fork al día

```bash
git switch main
git fetch upstream
git rebase upstream/main
git push origin main
```
