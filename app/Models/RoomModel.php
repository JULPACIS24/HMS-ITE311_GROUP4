<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table            = 'rooms';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'room_name',
        'room_type',
        'floor',
        'capacity',
        'status',
        'description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'room_name' => 'required|min_length[3]|max_length[100]|is_unique[rooms.room_name,id,{id}]',
        'room_type' => 'required|in_list[Consultation,Operating,Recovery,ICU,General,Ward]',
        'floor' => 'required|integer|greater_than[0]|less_than[100]',
        'capacity' => 'required|integer|greater_than[0]|less_than[100]',
        'status' => 'required|in_list[Available,Occupied,Maintenance,Reserved]'
    ];

    protected $validationMessages   = [
        'room_name' => [
            'required' => 'Room name is required',
            'min_length' => 'Room name must be at least 3 characters long',
            'max_length' => 'Room name cannot exceed 100 characters',
            'is_unique' => 'Room name already exists'
        ],
        'room_type' => [
            'required' => 'Room type is required',
            'in_list' => 'Invalid room type selected'
        ],
        'floor' => [
            'required' => 'Floor number is required',
            'integer' => 'Floor must be a number',
            'greater_than' => 'Floor must be greater than 0',
            'less_than' => 'Floor must be less than 100'
        ],
        'capacity' => [
            'required' => 'Capacity is required',
            'integer' => 'Capacity must be a number',
            'greater_than' => 'Capacity must be greater than 0',
            'less_than' => 'Capacity must be less than 100'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Invalid status selected'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Get all available rooms
     */
    public function getAvailableRooms()
    {
        return $this->where('status', 'Available')
                    ->orderBy('room_name', 'ASC')
                    ->findAll();
    }

    /**
     * Get rooms by type
     */
    public function getRoomsByType($type)
    {
        return $this->where('room_type', $type)
                    ->where('status', 'Available')
                    ->orderBy('room_name', 'ASC')
                    ->findAll();
    }

    /**
     * Get rooms for dropdown selection
     */
    public function getRoomsForDropdown()
    {
        $rooms = $this->where('status', 'Available')
                      ->orderBy('room_name', 'ASC')
                      ->findAll();
        
        $dropdown = [];
        foreach ($rooms as $room) {
            $dropdown[$room['id']] = $room['room_name'] . ' (' . $room['room_type'] . ' - Floor ' . $room['floor'] . ')';
        }
        
        return $dropdown;
    }

    /**
     * Update room status
     */
    public function updateRoomStatus($roomId, $status)
    {
        return $this->update($roomId, ['status' => $status]);
    }

    /**
     * Check if room is available
     */
    public function isRoomAvailable($roomId)
    {
        $room = $this->find($roomId);
        return $room && $room['status'] === 'Available';
    }

    /**
     * Get room details by ID
     */
    public function getRoomDetails($roomId)
    {
        return $this->find($roomId);
    }

    /**
     * Search rooms by name or type
     */
    public function searchRooms($searchTerm)
    {
        return $this->like('room_name', $searchTerm)
                    ->orLike('room_type', $searchTerm)
                    ->orLike('floor', $searchTerm)
                    ->orderBy('room_name', 'ASC')
                    ->findAll();
    }
}
