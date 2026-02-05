<section class="space-y-4">
    {{-- Header --}}
    <div class="bg-white border border-slate-200 rounded-lg p-5">
        <h2 class="text-base sm:text-lg font-extrabold text-slate-900">
            Profil
        </h2>
        <p class="mt-1 text-sm text-slate-600">
            Mettez à jour vos informations et votre photo de profil.
        </p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"
          class="bg-white border border-slate-200 rounded-lg">
        @csrf
        @method('patch')

        <div class="p-5 grid grid-cols-12 gap-6">
            {{-- LEFT: fields --}}
            <div class="col-span-12 lg:col-span-8 space-y-5">

                {{-- Name --}}
                <div>
                    <x-input-label for="name" :value="__('Nom complet')" class="text-slate-700 font-bold" />
                    <x-text-input
                        id="name" name="name" type="text"
                        class="mt-1 block w-full rounded-md border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                        :value="old('name', $user->name)"
                        required autofocus autocomplete="name"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-bold" />
                    <x-text-input
                        id="email" name="email" type="email"
                        class="mt-1 block w-full rounded-md border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                        :value="old('email', $user->email)"
                        required autocomplete="username"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-3 rounded-md border border-amber-200 bg-amber-50 p-3">
                            <p class="text-sm text-amber-900">
                                {{ __('Votre email n’est pas vérifié.') }}
                                <button form="send-verification"
                                        class="ml-1 underline font-bold text-amber-900 hover:text-amber-800">
                                    {{ __('Renvoyer le lien') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm font-semibold text-emerald-700">
                                    {{ __('Un lien de vérification a été envoyé.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Specialty --}}
                <div>
                    <x-input-label for="specialty" :value="__('Spécialité')" class="text-slate-700 font-bold" />
                    <x-text-input
                        id="specialty" name="specialty" type="text"
                        class="mt-1 block w-full rounded-md border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                        :value="old('specialty', $user->profile?->specialty)"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('specialty')" />
                </div>

                {{-- Bio --}}
                <div>
                    <x-input-label for="bio" :value="__('Bio / Description')" class="text-slate-700 font-bold" />
                    <textarea
                        id="bio" name="bio" rows="5"
                        class="mt-1 block w-full rounded-md border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                        placeholder="Parlez un peu de vous..."
                    >{{ old('bio', $user->profile?->bio) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                </div>
            </div>

            {{-- RIGHT: photo --}}
            <div class="col-span-12 lg:col-span-4">
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">
                    <p class="text-sm font-extrabold text-slate-900">Photo de profil</p>
                    <p class="text-xs text-slate-600 mt-1">PNG/JPG, max 2MB.</p>

                    <div class="mt-4 flex items-center gap-4">
                        @if($user->profile?->photo)
                            <img
                                src="{{ asset('storage/'.$user->profile->photo) }}"
                                class="w-16 h-16 rounded-full object-cover border border-slate-200"
                                alt="Photo"
                            >
                        @else
                            <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center font-extrabold text-indigo-700 text-2xl border border-slate-200">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="min-w-0">
                            <label for="photo"
                                   class="inline-flex items-center justify-center px-4 py-2 rounded-full bg-indigo-600 text-white text-sm font-extrabold hover:bg-indigo-700 transition cursor-pointer">
                                Choisir une photo
                            </label>
                            <input id="photo" name="photo" type="file" accept="image/*" class="hidden">
                            <p class="mt-2 text-xs text-slate-500">Astuce: une photo carrée rend mieux.</p>
                        </div>
                    </div>

                    <x-input-error class="mt-3" :messages="$errors->get('photo')" />
                </div>
            </div>
        </div>

        {{-- Footer actions --}}
        <div class="px-5 py-4 border-t border-slate-200 flex items-center justify-between">
            <p class="text-xs text-slate-500">
                Vos informations sont visibles selon vos paramètres.
            </p>

            <div class="flex items-center gap-3">
                <x-primary-button class="rounded-full !px-6 !py-2">
                    {{ __('Enregistrer') }}
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }"
                       x-show="show"
                       x-transition
                       x-init="setTimeout(() => show = false, 2000)"
                       class="text-sm font-semibold text-emerald-700">
                        {{ __('Enregistré ✓') }}
                    </p>
                @endif
            </div>
        </div>
    </form>
</section>
