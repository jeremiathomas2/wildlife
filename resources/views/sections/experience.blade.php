@props([])

<!-- Tanzania Experience Section -->
<section class="py-20 lg:py-28 relative overflow-hidden" style="background: linear-gradient(135deg, #631e08 0%, #854208 50%, #631e08 100%);">
    <!-- Decorative elements -->
    <div class="absolute top-0 left-0 w-96 h-96 rounded-full opacity-10" style="background: radial-gradient(circle, #ff9729 0%, transparent 70%); filter: blur(60px);"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full opacity-10" style="background: radial-gradient(circle, #088529 0%, transparent 70%); filter: blur(60px);"></div>

    <div class="relative z-10 max-w-[1280px] mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-sm font-semibold uppercase tracking-[0.15em] mb-3 block" style="color: #ff9729; font-family: 'Raleway', sans-serif;">
                Experience Tanzania
            </span>
            <h2 class="font-bold mb-4" style="font-family: 'Raleway', sans-serif; font-size: clamp(2rem, 5vw, 3.5rem); color: #ffffff; line-height: 1.1;">
                Your Safari Adventure Awaits
            </h2>
            <p class="text-lg max-w-2xl mx-auto" style="color: rgba(255,255,255,0.85);">
                From the vast Serengeti plains to the pristine beaches of Zanzibar, discover the magic of Tanzania through unforgettable experiences.
            </p>
        </div>

        <!-- Experience Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <a href="{{ route('destinations') }}" class="group relative rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-2 block" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="aspect-[4/5] relative">
                    <img src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_800/v1783506719/Screenshot_2026-07-08_033102_qp2cgp.png" alt="Serengeti Safari" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background: #ff9729;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M2 12h20"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2" style="font-family: 'Raleway', sans-serif; color: #ffffff;">Serengeti Safari</h3>
                        <p class="text-sm" style="color: rgba(255,255,255,0.8);">Witness the Great Migration and Big Five in their natural habitat</p>
                    </div>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('destinations') }}" class="group relative rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-2 block" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="aspect-[4/5] relative">
                    <img src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_800/v1783497617/Screenshot_2026-07-08_005522_sonnrs.png" alt="Mount Kilimanjaro" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background: #088529;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m8 3 4 8 5-5 5 15H2L8 3z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2" style="font-family: 'Raleway', sans-serif; color: #ffffff;">Kilimanjaro Trek</h3>
                        <p class="text-sm" style="color: rgba(255,255,255,0.8);">Conquer Africa's highest peak with expert guides and stunning views</p>
                    </div>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('destinations') }}" class="group relative rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-2 block" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="aspect-[4/5] relative">
                    <img src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_800/v1783432553/pexels-mck-242487578-14667295_oxtpwj.jpg" alt="Zanzibar Beach" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background: #088529;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 12h20"/>
                                <path d="M12 2v20"/>
                                <circle cx="12" cy="12" r="10"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2" style="font-family: 'Raleway', sans-serif; color: #ffffff;">Zanzibar Escape</h3>
                        <p class="text-sm" style="color: rgba(255,255,255,0.8);">Relax on pristine beaches and explore historic Stone Town</p>
                    </div>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="{{ route('destinations') }}" class="group relative rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-2 block" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="aspect-[4/5] relative">
                    <img src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_800/v1783352695/maasai_tribe_ggsbdm.jpg" alt="Cultural Experience" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background: #ff9729;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-2" style="font-family: 'Raleway', sans-serif; color: #ffffff;">Cultural Tours</h3>
                        <p class="text-sm" style="color: rgba(255,255,255,0.8);">Immerse yourself in Maasai culture and local traditions</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Stats Bar -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold mb-2" style="font-family: 'Raleway', sans-serif; color: #ff9729;">15+</div>
                <div class="text-sm" style="color: rgba(255,255,255,0.8);">Years Experience</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold mb-2" style="font-family: 'Raleway', sans-serif; color: #ff9729;">10K+</div>
                <div class="text-sm" style="color: rgba(255,255,255,0.8);">Happy Travelers</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold mb-2" style="font-family: 'Raleway', sans-serif; color: #ff9729;">50+</div>
                <div class="text-sm" style="color: rgba(255,255,255,0.8);">Expert Guides</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold mb-2" style="font-family: 'Raleway', sans-serif; color: #ff9729;">100%</div>
                <div class="text-sm" style="color: rgba(255,255,255,0.8);">Satisfaction Rate</div>
            </div>
        </div>
    </div>
</section>
