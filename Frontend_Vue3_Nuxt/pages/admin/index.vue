<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {Search, SquareChevronLeft, CircleUserRound, IdCard, AtSign, SeparatorVertical } from 'lucide-vue-next';
import { Input } from '@/components/ui/input';
import { ref } from 'vue';

type userType = {
  id: number;
  name: string;
  email: string;
}

const user = ref<userType>({id: 1, name: 'John Doe', email: 'john@john.com'});
</script>

<template>
  <!-- Section where information about login user will be like id, name, email -->
  <div class="flex justify-between items-center p-4 bg-white border-b border-gray-200">
    <div class="flex items-center">
      <NuxtLink to="/">
        <Button variant="outline" size="sm">
          <SquareChevronLeft class="w-6 h-6"/>
        </Button>
        <span class="pl-2">Back</span>
      </NuxtLink>
    </div>
    <h1 class="text-xl font-semibold">Admin Dashboard</h1>
  </div>

  <div class="flex flex-wrap p-4">
    <div class="p-2 relative flex-1 min-w-[200px]">
      <Input v-model="user.id" type="text" placeholder="ID" class="pl-10" disabled/>
      <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
        <IdCard class="text-muted-foreground" />
      </span>
    </div>

    <div class="p-2 relative flex-1 min-w-[200px]">
      <Input v-model="user.name" type="text" placeholder="Name" class="pl-10" disabled/>
      <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
        <CircleUserRound class="text-muted-foreground" />
      </span>
    </div>

    <div class="p-2 relative flex-1 min-w-[200px]">
      <Input v-model="user.email" type="text" placeholder="Email" class="pl-10" disabled/>
      <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
        <AtSign class="text-muted-foreground" />
      </span>
    </div>
  </div>

  <div class="flex flex-wrap justify-center p-4 bg-white border-t border-gray-200 items-center">
    <div>
      <NuxtLink to="/">
        <Button variant="outline" size="sm">
          Get all pending courses
        </Button>
      </NuxtLink>
      <NuxtLink to="/" class="pl-2">
        <Button variant="outline" size="sm">
          Accept all pending courses
        </Button>
      </NuxtLink>
    </div>
    <SeparatorVertical class="pl-2"/>
    <div class="sm:pt-2">
      <NuxtLink to="/" class="pl-2">
        <Button variant="outline" size="sm">
          Get all active timetables
        </Button>
      </NuxtLink>
      <NuxtLink to="/" class="pl-2">
        <Button variant="outline" size="sm">
          Download all timetables
        </Button>
      </NuxtLink>
    </div>
  </div>
</template>
