<script setup lang="ts">
import { sendCourseRequest } from '~/data/requests';
import { ref, defineProps } from 'vue';
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
const closeBtn = ref<HTMLElement | null>(null);
const props = defineProps<{
  course_code: string;
  course_id: number;
}>();

const response = ref<string>('');

const onCloseClick = () => {
  //close the element
  console.log('Close clicked');

}
const onYesClick = () => {
  console.log('Yes clicked');
  sendCourseRequest(props.course_code)
    .then((res) => {
      response.value = res.message;
      console.log('Response:', res);
    })
    .catch((err) => {
      response.value = err;
      console.log('Error:', err);
      // then after 2 seconds, reset the response
    });
  setTimeout(() => {
    response.value = '';
  }, 5000);
}

</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button size="sm" variant="outline">
        Add new request
      </Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle v-if="response !== ''">Status</DialogTitle>
        <DialogTitle v-else>Add new request</DialogTitle>

        <DialogDescription v-if="response == ''">
          {{ response }}
          Are you sure you like to add new request?
        </DialogDescription>
      </DialogHeader>
      <div v-if="response !== ''">
        <DialogDescription>
          {{ response }}
        </DialogDescription>
      </div>

      <div v-else class="grid gap-4 py-4">
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="course_code" class="text-right">
            Course code
          </Label>
          <Input id="course_code" :value="props.course_code" :placeholder="props.course_code" class="col-span-3" disabled/>
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="course_id" class="text-right">
            Course id
          </Label>
          <Input id="course_id" :value="props.course_id" :placeholder="props.course_id" class="col-span-3" disabled/>
        </div>
      </div>

      <div v-if = "response === ''">
        <div class="flex flex-row sm:flex-row sm:justify-end gap-x-2">
          <DialogClose as-child>
            <Button class="w-full">
              No
            </Button>
          </DialogClose>
          <Button type="button" @click="onYesClick" class="w-full sm:gap-x-2">
            Yes
          </Button>
        </div>

      </div>

      <div v-else>
        <DialogFooter>
          <DialogClose as-child >
            <Button class="w-full" @click="onCloseClick">
              Close
            </Button>
          </DialogClose>
        </DialogFooter>
    </div>
    </DialogContent>
  </Dialog>
</template>