# Apps on meekohi.com

This directory is the public home for interactive tools. It is ordinary static HTML and assets, served by the same host as the rest of the website. No Node process, database, rewrite rules, or site-wide framework is required.

## Organization

```text
apps/
  index.html                 App directory
  assets/apps.css            Shared styles for directory and project pages
  cislunar/
    index.html               Project overview / choice of viewer
    media/                   Screenshots used by the website
    live/                    Generated Live Orbit Lab deployment
    catalog/                 Generated Catalog Observatory deployment, including data/
```

For a new standalone app, use `apps/<short-name>/`. For several tools in one project, use an overview at `apps/<project>/` and a folder per tool beneath it, as with Cislunar. Add the project to `apps/index.html`; feature it in the homepage Projects list when appropriate. Reuse `assets/apps.css` for overview pages, while letting each app own its interface. Use relative links and a trailing slash for directory URLs.

Each app should offer a way back to All apps and its related tools. Build assets must use a relative base (`./`) so the directory tree also works in a local preview or under a hosting prefix. Keep source and build dependencies in the app's own source repository; this website tracks the files needed to serve it. Do not upload node_modules, build caches, or development servers.

## Updating the cislunar viewers

The editable source currently lives in the separate `cisluanr` checkout (the directory spelling is intentional here). From that checkout:

```sh
npm ci
npm run export:website -- --site ../meekohi.com
```

The export builds both viewers, then replaces only `apps/cislunar/live/` and `apps/cislunar/catalog/`. It recognizes those generated folders by `build-info.json`. It leaves the overview, app directory, screenshots, and homepage alone. Edit source and export again rather than editing hashed JavaScript bundles here. Review the website's Git diff afterward; obsolete generated assets are removed by the export, so include deletions when publishing.

Catalog Observatory includes a dated satellite and mission-data snapshot. To refresh it, run `npm run data:refresh:catalog` in the source checkout before exporting. Refreshing needs network access; viewing the exported app does not call upstream data services. Data coverage and provenance are available inside the viewer and its `data/` files. Live Orbit Lab uses idealized dynamics and does not need dated catalog updates.

## Preview and publish

From this website checkout:

```sh
python3 -m http.server 5180 --bind 127.0.0.1
# http://127.0.0.1:5180/apps/
```

Preview over HTTP rather than opening HTML as a local file: the viewers load module workers and JSON. Check homepage → Apps → Cislunar → both viewers, and the links back. At narrow widths, navigation should remain accessible and canvases should resize.

Publish the existing website normally, including this complete `apps/` tree and the homepage change. The same files work with Apache hosting or GitHub Pages. A Git commit by itself does not prove the Lithium-hosted website has been updated; the existing upload/deployment mechanism still needs to run. No hosting or DNS settings have been changed by this integration.

The cislunar dev servers link to each other on ports 5174/5175. To point their All apps and Cislunar links at a local website preview too, start them with `VITE_APPS_HOME=http://127.0.0.1:5180/apps/`.
