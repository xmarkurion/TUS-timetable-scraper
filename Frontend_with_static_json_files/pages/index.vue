<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { ChevronRight } from 'lucide-vue-next'
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
</script>

<template>
  <Table>
    <TableCaption>A list of time tables.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[100px] text-right">
          Course short code
        </TableHead>
        <TableHead>Details</TableHead>
        <TableHead class="text-right">
          Action
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>

      <TableRow>
        <TableCell class="font-medium">
          AL_KMOBA_8_4
        </TableCell>
        <TableCell>Connected Devices</TableCell>
        <TableCell class="text-right">
          <NuxtLink :to="'/devices'">
            <Button variant="outline" size="icon">
              <ChevronRight class="w-4 h-4" />
            </Button>
          </NuxtLink>
        </TableCell>
      </TableRow>

      <TableRow>
        <TableCell class="font-medium">
          AL_KAICC_8_4
        </TableCell>
        <TableCell>Cloud with AI</TableCell>
        <TableCell class="text-right">
          <NuxtLink :to="'/cloud'">
            <Button variant="outline" size="icon">
              <ChevronRight class="w-4 h-4" />
            </Button>
          </NuxtLink>
        </TableCell>
      </TableRow>

    </TableBody>
  </Table>
</template>