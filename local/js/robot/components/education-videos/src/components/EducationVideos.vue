<template>
  <div class="b-study">
    <a @click="openVideo" href="javascript:void(0)" class="b-study__item">
            <span class="h5 b-study__name">
                Урок 1. Основы схемотехники
            </span>
      <p class="b-study__description">
        В видео рассмотрено понятие электрического тока, его основные параметры: напряжение, сопротивление, сила тока; связь этих параметров через закон Ома. Далее разобраны основные элементы, которые могут встретиться на электрической схеме: резисторы, конденсаторы, диоды, светодиоды, разъемы, микросхемы. Показано как читать электрические схемы и что общего у электрической схемы и платы устройства. В конце видео показаны основные моменты работы с лабораторным блоком питания и мультиметром.
      </p>
      <span class="b-study__icon">
        <svg><use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#arrow_right"></use></svg>
            </span>
    </a>
    <a @click="openVideo" href="javascript:void(0)" class="b-study__item">
            <span class="h5 b-study__name">
                Урок 2. Основы пайки и монтажа радиоэлементов
            </span>
      <p class="b-study__description">
        В данном видео показано на примерах как припаять на плату SMD резистор, разъем PLS. А также как припаять разъем на провод.
      </p>
      <span class="b-study__icon">
                <svg><use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#arrow_right"></use></svg>
            </span>
    </a>
    <a @click="openVideo" href="javascript:void(0)" class="b-study__item">
            <span class="h5 b-study__name">
                Урок 3.1. Основы 3D моделирования и конструирования
            </span>
      <p class="b-study__description">
        В данном видеоуроке показаны основы работы с 3D элементами в САПР Компас-3D. На примере показано как создаются 3D модели деталей, необходимых для сборки мобильного робота. В процессе создания моделей рассматривается работа с эскизами, операции выдавливания, вырезания и элементы вращения.
      </p>
      <span class="b-study__icon">
                <svg><use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#arrow_right"></use></svg>
            </span>
    </a>
    <a @click="openVideo" href="javascript:void(0)" class="b-study__item">
            <span class="h5 b-study__name">
                Урок 3.2. Сборка в компасе
            </span>
      <p class="b-study__description">
        В данном видеоуроке показано как работать со сборочными единицами в САПР Компас-3D.
      </p>
      <span class="b-study__icon">
                <svg><use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#arrow_right"></use></svg>
            </span>
    </a>
    <a @click="openVideo" href="javascript:void(0)" class="b-study__item">
            <span class="h5 b-study__name">
                Урок 4. Основы работы с 3D принтером и станком для лазерной резки
            </span>
      <p class="b-study__description">
        В данном видеоуроке показано как подготовить 3D модели для печати на 3D принтере или для станка лазерной резки. Рассмотрен процесс сохранения модели в формате STL. Показана работа с STL моделью в специализированном ПО для 3D-принтера, разобраны основные параметры печати. На примере показано как создать эскиз для станка лазерной резки.
      </p>
      <span class="b-study__icon">
                <svg><use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#arrow_right"></use></svg>
            </span>
    </a>
    <a @click="openVideo" href="javascript:void(0)" class="b-study__item">
            <span class="h5 b-study__name">
                Урок 5. Программирование микроконтроллеров
            </span>
      <p class="b-study__description">
        В данном видеоуроке показано, как работать с микроконтроллером ESP32, как его программировать в среде Arduino IDE, какие у него есть возможности и в чем заключаются отличия в программировании в сравнении с платами Arduino. Разобрано, что такое ШИМ-сигнал, а также, как работать с аппаратным модулем Bluetooth на ESP32. Сайт Алекса Гайвера: alexgyver.ru Сайт с уроками Ардуино: робототехника18.рф Ссылка для менеджера плат: https://dl.espressif.com/dl/package_esp32_index.json
      </p>
      <span class="b-study__icon">
                <svg><use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#arrow_right"></use></svg>
            </span>
    </a>
    <a @click="openVideo" href="javascript:void(0)" class="b-study__item">
            <span class="h5 b-study__name">
                Урок 6. Датчики роботов
            </span>
      <p class="b-study__description">
        В данном видеоуроке рассмотрены основные датчики, которые могут использоваться на мобильном роботе для автономного движения. Рассмотрены ультразвуковой и лазерный датчики расстояния, датчик контрастной полосы, датчики угловых перемещений – энкодеры.
      </p>
      <span class="b-study__icon">
                <svg><use xlink:href="/local/templates/robot/app/dist/assets/icons/sprite.svg#arrow_right"></use></svg>
            </span>
    </a>

    <MediaPopup
        :toggle="toggle"
        :item="popupContent"
        @close="closePopup"
    />
  </div>
</template>

<script setup>
import MediaPopup from "MediaPopup";
import {reactive, ref} from "vue";

const toggle = ref(false);
const popupContent = reactive({
  url: "",
  preview: "",
  name: "",
  type: "",
  isVideo: false
});

const openVideo = () => {
  toggle.value = true;
  Object.assign(popupContent, {
    name: "Урок 1. Основы схемотехники",
    url: "/local/templates/robot/app/video/demo_video.mp4",
    preview: "/local/templates/robot/app/img/archive_video_1.webp",
    type: "video/mp4",
    isVideo: true
  });
}

const closePopup = () => {
  toggle.value = false;
  setTimeout(() => {
    Object.assign(popupContent, {
      url: "",
      preview: "",
      name: "",
      type: "",
      isVideo: false
    });
  }, 300);
}

</script>