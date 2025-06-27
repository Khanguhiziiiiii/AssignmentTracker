class Solution:
    def sortArray(self, nums):
        if len(nums) <= 1:
            return nums  # Base case
        
        mid = len(nums) // 2
        left = self.sortArray(nums[:mid])  # Sort left half
        right = self.sortArray(nums[mid:])  # Sort right half
        
        return self.merge(left, right)  # Merge sorted halves

    def merge(self, left, right):
        sorted_arr = []
        i = j = 0
        
        while i < len(left) and j < len(right):
            if left[i] < right[j]:
                sorted_arr.append(left[i])
                i += 1
            else:
                sorted_arr.append(right[j])
                j += 1
        
        sorted_arr.extend(left[i:])  # Append remaining elements
        sorted_arr.extend(right[j:])
        
        return sorted_arr
