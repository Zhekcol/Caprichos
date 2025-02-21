class Slider {
    constructor(sliderContainerSelector) {
        this.sliderContainer = document.querySelector(sliderContainerSelector);
        this.slider = this.sliderContainer.querySelector('.slider');
        this.nextButton = this.sliderContainer.querySelector('.slider-next');
        this.prevButton = this.sliderContainer.querySelector('.slider-prev');
        this.itemsToShowOnLargeScreen = 3;
        this.itemsToShowOnSmallScreen = 1;
        this.actualIndex = 0;

        this.init();
    }

    

    init() {
        this.nextButton.addEventListener('click', () => this.nextSlide());
        this.prevButton.addEventListener('click', () => this.prevSlide());
        window.addEventListener('resize', () => this.fixSliderOnResize());
        this.updateSlider();
    }

    updateSlider() {
        const sliderItemWidth = this.slider.querySelector('.slider-item').offsetWidth;
        this.slider.style.transform = `translateX(-${this.actualIndex * sliderItemWidth}px)`;
    }

    fixSliderOnResize() {
        const screenWidth = window.innerWidth;
        const itemsToShow = screenWidth < 992 ? this.itemsToShowOnSmallScreen : this.itemsToShowOnLargeScreen;
        const maxIndex = this.slider.children.length - itemsToShow;

        if (this.actualIndex > maxIndex) {
            this.actualIndex = maxIndex;
        }

        this.updateSlider();
    }

    nextSlide() {
        const screenWidth = window.innerWidth;
        const itemsToShow = screenWidth < 992 ? this.itemsToShowOnSmallScreen : this.itemsToShowOnLargeScreen;
        if (this.actualIndex < this.slider.children.length - itemsToShow) {
            this.actualIndex++;
            this.updateSlider();
        }
    }

    prevSlide() {
        if (this.actualIndex > 0) {
            this.actualIndex--;
            this.updateSlider();
        }
    }
}

// Inicializar sliders
new Slider('.hombres'); // Slider de Hombres
new Slider('.mujeres'); // Slider de Mujeres
new Slider('.accesorios'); // Slider de Accesorios