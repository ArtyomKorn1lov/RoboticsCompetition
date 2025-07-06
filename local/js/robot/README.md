Frontend vue 3 (robot)
===

## Краткое описание:
Frontend на основе фреймворка vue 3, представляет собой сборку отдельных extention для многостраничного сайта, с минимальным переиспользованием одних и тех же сборок

## Техническая информация:
- **node** `>=20.11.0`
- **npm** `>=10.2.4`
- **vue** `3.5.13`
- **element-plus** `2.9.4`
- **axios** `1.7.9`
- **swiper** `11.2.4`
- **vue-the-mask** `0.11.1`
- **Сборщик** - webpack `5.97.1`

## Команды для сборки (точечно каждого из extention):
- `npx webpack-cli --watch --mode development` - сборка extention в режиме *watch*
- `npx webpack-cli --mode development` - сборка extention в режиме *dev*
- `npx webpack-cli` - сборка extention в режиме *prod*

## Структура проекта
- `/core` - подключение ядра vue, и других связанных плагинов
- `/ui` - ui-компоненты из внешних библиотек
- `/tools` - библиотека классов, функций и тд
- `/components` - frontend-компоненты
- `/composable` - хуки для переиспользования логики компонентов
- `jsconfig.json` - конфиг для импорта модулей из разных extention

Структура extention - стандартная структура extention 1С-Битрикс 