<template>
    <header class="w-full h-12 p-5 bg-sidebar-color flex justify-between lg:justify-end items-center drop-shadow-sm z-0">
        <div class="menu-icon lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </div>

        <div class="profile-icon flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
    
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </div>
    </header>

    <div class="sidebar hide-sidebar bg-sidebar-color drop-shadow-md px-5 py-5 w-[70%] max-h-screen h-screen absolute top-0 z-10 lg:translate-x-0 lg:w-[20%] box-border">
        <div class="logo mb-10 flex justify-between w-[8rem]">
            <img src="images/logo/logo.svg" alt="logo">
        </div>
       
        <div class="menus">
            <ul class="flex flex-col  overflow-y-auto  max-h-[80vh]">
                <li class="flex gap-3 items-center hover:bg-indigo-500 p-2 rounded-md hover:cursor-pointer active:bg-indigo-800  group ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="rgb(100 116 139)" class="size-5 group-hover:stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                    </svg>

                    <p class="font-semibold text-slate-500 text-sm group-hover:text-slate-50">Dashboard</p>
                </li>
                <li class="flex gap-3 items-center hover:bg-indigo-500 p-2 rounded-md hover:cursor-pointer active:bg-indigo-800 focus:bg-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="rgb(100 116 139)" class="size-5 group-hover:stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>

                    <p class="font-semibold text-slate-500 text-sm group-hover:text-slate-50">Team</p>
                </li>
                <li class="flex gap-3 items-center hover:bg-indigo-500 p-2 rounded-md hover:cursor-pointer active:bg-indigo-800 focus:bg-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="rgb(100 116 139)" class="size-5 group-hover:stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                    </svg>

                    <p class="font-semibold text-slate-500 text-sm group-hover:text-slate-50">Projects</p>
                </li>
                <li class="flex gap-3 items-center hover:bg-indigo-500 p-2 rounded-md hover:cursor-pointer active:bg-indigo-800 focus:bg-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="rgb(100 116 139)" class="size-5 group-hover:stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>

                    <p class="font-semibold text-slate-500 text-sm group-hover:text-slate-50">Calendar</p>
                </li>
                <li class="flex gap-3 items-center hover:bg-indigo-500 p-2 rounded-md hover:cursor-pointer active:bg-indigo-800 focus:bg-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="rgb(100 116 139)" class="size-5 group-hover:stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>


                    <p class="font-semibold text-slate-500 text-sm group-hover:text-slate-50">Documents</p>
                </li>
                <li class="flex gap-3 items-center hover:bg-indigo-500 p-2 rounded-md hover:cursor-pointer active:bg-indigo-800 focus:bg-indigo-600 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="rgb(100 116 139)" class="size-5 group-hover:stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>

                    <p class="font-semibold text-slate-500 text-sm group-hover:text-slate-50">Reports</p>
                </li>
            </ul>
        </div>

    </div>

    <div class="shadow-sidebar hide-sidebar bg-slate-900/80 h-screen w-full absolute top-0 lg:hidden flex justify-end">
        <div id="button-close" class="button-close md:object-none p-5 -translate-y-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#ffff" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>

        </div>
    </div>

    <main></main>
    <footer></footer>
</template>

<script>
export default {
    mounted() {
        
        const hamburgerMenu = document.querySelector('.menu-icon');
        const buttonCLose = document.getElementById('button-close');
        const shadowSidebar = document.querySelector('.shadow-sidebar');
        const sidebar = document.querySelector('.sidebar');

        window.addEventListener('resize', () => {
            const width = window.innerWidth;

            if(width > 1020) {
                this.hideSidebar(shadowSidebar, sidebar);
            }
        });

        buttonCLose.addEventListener("click", () => {
            this.hideSidebar(shadowSidebar, sidebar);
        })

        hamburgerMenu.addEventListener("click", () => {
            this.showSidebar(shadowSidebar, sidebar);
        })

    },

    methods: {
        async logout() {
            await window.axios.post('/logout').then((e) => {
                this.$notyf.success('Logout successful!')
                window.location = '/'
            })
        },

        hideSidebar(shadowSidebar, sidebar) {
            shadowSidebar.classList.add("hide-sidebar");
            shadowSidebar.classList.remove("show-sidebar");
            sidebar.classList.add("hide-sidebar");
            sidebar.classList.remove("show-sidebar");
        },

        showSidebar(shadowSidebar, sidebar) {
            shadowSidebar.classList.add("show-sidebar");
            shadowSidebar.classList.remove("hide-sidebar");
            sidebar.classList.add("show-sidebar");
            sidebar.classList.remove("hide-sidebar");
        }
    },
}
</script>
