#!/bin/bash

BUILD_MODE=""
if [ "$1" == "dev" ]; then
    BUILD_MODE="--mode development"
    echo "⚙️ Запуск сборки в режиме: DEVELOPMENT"
else
    BUILD_MODE=""
    echo "🚀 Запуск сборки в режиме: PRODUCTION (по умолчанию)"
fi

ROOT_DIR=$(dirname "$0")

find "$ROOT_DIR" -type f -name "webpack.config.js" -print0 | while IFS= read -r -d $'\0' config_file; do
    project_dir=$(dirname "$config_file")

    echo "----------------------------------------------------"
    echo "📦 Найдена конфигурация в: $project_dir"

    if ! command -v npx &> /dev/null; then
        echo "❌ Ошибка: Команда 'npx' не найдена. Убедитесь, что Node.js и npm установлены."
        break
    fi

    (
        cd "$project_dir" || { echo "❌ Ошибка: Не удалось перейти в директорию $project_dir"; exit 1; }

        echo "🔨 Запуск: npx webpack-cli $BUILD_MODE"

        npx webpack-cli $BUILD_MODE

        if [ $? -eq 0 ]; then
            echo "✅ Сборка успешно завершена в $project_dir"
        else
            echo "❌ Ошибка сборки в $project_dir"
        fi
    )

    echo "----------------------------------------------------"
done

echo "===================================================="
echo "🎉 Скрипт сборки завершен."