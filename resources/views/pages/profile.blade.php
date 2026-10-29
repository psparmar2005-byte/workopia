 <x-layout>
     <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-xl mx-auto mt-6">
         <h3 class="text-3xl text-center font-bold mb-4">
             Profile Info
         </h3>
         <form method="POST" action="{{ route('profile.show') }}" enctype="multipart/form-data">
             @csrf
             @method('PUT')

             <x-inputs.text id="name" name="name" label="Name" :value="$user->name" />
             <x-inputs.text id="email" name="email" label="Email" :value="$user->email" />
             <x-inputs.file id="avatar" name="avatar" label="Upload Avatar" />
             <button class="bg-green-500 px-4 py-2 rounded w-full text-white hover:bg-green-600"
                 type="submit">Save</button>
         </form>

     </div>
 </x-layout>
