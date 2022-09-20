<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Pengadaan;
use App\Models\Position;
use App\Models\SubDepartment;
use App\Models\Ticket;
use App\Models\User;

class GetAttributeController extends Controller
{
    /**
     * Get the Category data
     * 
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function getCategory(Ticket $ticket)
    {
        $categories = Category::all();
        $ticket = Ticket::find($ticket->id);
        $opt = "";

        foreach ($categories as $category) {
            $opt .= '<option value="' . $category->id . '" ' . (($ticket->category_id === $category->id) ? "selected" : "") . '>' . $category->category . '</option>';
        }

        return $opt;
    }

    /**
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function getPermintaan($ticket)
    {
        $pengadaan = Pengadaan::where('ticket_id', $ticket)->first();

        return response()->json($pengadaan);
    }

    /**
     * Get the selected Department
     * 
     * @param  \App\Models\User  $user
     * @return $opt
     */
    public function getSelectedDepartment(User $user)
    {
        $departments = Department::all();

        $user = User::find($user->id);

        $opt = "";

        if (empty($user->employee->sub_department_id)) {
            $opt .= '<option selected>-</option>';
            foreach ($departments as $department) {
                $opt .= '<option value="' . $department->id . '">' . $department->department . '</option>';
            }
        } else {
            $opt .= '<option>-</option>';
            foreach ($departments as $department) {
                $opt .= '<option value="' . $department->id . '" ' . (($user->employee->sub_department->department_id === $department->id) ? "selected" : "") . '>' . $department->department . '</option>';
            }
        }

        return $opt;
    }

    /**
     * Get the selected Department
     * 
     * @param  \App\Models\User  $user
     * @return $opt
     */
    public function getSelectedTechnicianDepartment(User $user)
    {
        $departments = Department::all();

        $user = User::find($user->id);

        $opt = "";

        $opt .= '<option>-</option>';
        foreach ($departments as $department) {
            $opt .= '<option value="' . $department->id . '" ' . (($user->technician->sub_department->department_id === $department->id) ? "selected" : "") . '>' . $department->department . '</option>';
        }

        return $opt;
    }

    /**
     * Get the selected Gender
     * 
     * @param  \App\Models\User
     * @return $opt
     */
    public function getSelectedGender(User $user)
    {
        $genders = Gender::all();

        $user = User::find($user->id);

        $opt = "";

        foreach ($genders as $gender) {
            $opt .= '<option value="' . $gender->id . '" ' . (($user->employee->gender_id === $gender->id) ? "selected" : "") . '>' . $gender->gender . '</option>';
        }

        return $opt;
    }

    /**
     * Get the selected Gender
     * 
     * @param  \App\Models\User
     * @return $opt
     */
    public function getSelectedTechnicianGender(User $user)
    {
        $genders = Gender::all();

        $user = User::find($user->id);

        $opt = "";

        foreach ($genders as $gender) {
            $opt .= '<option value="' . $gender->id . '" ' . (($user->technician->gender_id === $gender->id) ? "selected" : "") . '>' . $gender->gender . '</option>';
        }

        return $opt;
    }

    /**
     * Get the selected Sub Department
     * 
     * @param  \App\Models\Department  $department
     * @param  \App\Models\User  $user
     * @return $opt
     */
    public function getSelectedSubDepartment(User $user)
    {
        $subdepartments = SubDepartment::all();

        $user = User::find($user->id);

        $opt = "";

        if (empty($user->employee->sub_department_id)) {
            $opt .= '<option selected>-</option>';
            foreach ($subdepartments as $subdept) {
                $opt .= '<option value="' . $subdept->id . '">' . $subdept->sub_department . '</option>';
            }
        } else {
            $opt .= '<option>-</option>';
            foreach ($subdepartments as $subdept) {
                $opt .= '<option value="' . $subdept->id . '" ' . (($user->employee->sub_department_id === $subdept->id) ? "selected" : "") . '>' . $subdept->sub_department . '</option>';
            }
        }

        return $opt;
    }

    /**
     * Get the selected Sub Department
     * 
     * @param  \App\Models\Department  $department
     * @param  \App\Models\User  $user
     * @return $opt
     */
    public function getSelectedTechnicianSubDepartment(User $user)
    {
        $subdepartments = SubDepartment::all();

        $user = User::find($user->id);

        $opt = "";

        $opt .= '<option>-</option>';
        foreach ($subdepartments as $subdept) {
            $opt .= '<option value="' . $subdept->id . '" ' . (($user->technician->sub_department_id === $subdept->id) ? "selected" : "") . '>' . $subdept->sub_department . '</option>';
        }

        return $opt;
    }

    /**
     * Get the Position data
     * 
     * @param  \App\Models\User  $user
     * @return $opt
     */
    public function getPosition(User $user)
    {
        $positions = Position::all();

        $user = User::find($user->id);

        $opt = "";

        foreach ($positions as $position) {
            $opt .= '<option value="' . $position->id . '" ' . (($user->employee->position_id === $position->id) ? "selected" : "") . '>' . $position->position . '</option>';
        }

        return $opt;
    }

    /**
     * Get the Position data
     * 
     * @param  \App\Models\User  $user
     * @return $opt
     */
    public function getPositionTechnician(User $user)
    {
        $positions = Position::all();

        $user = User::find($user->id);

        $opt = "";

        foreach ($positions as $position) {
            $opt .= '<option value="' . $position->id . '" ' . (($user->technician->position_id === $position->id) ? "selected" : "") . '>' . $position->position . '</option>';
        }

        return $opt;
    }

    /**
     * Get the Sub Department data
     * 
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function getSubDepartment(Department $department)
    {
        $department = Department::find($department->id);
        $subDepartment = SubDepartment::where('department_id', $department->id)->get();
        $opt = "";

        foreach ($subDepartment as $subdept) {
            $opt .= '<option value="' . $subdept->id . '">' . $subdept->sub_department . '</option>';
        }

        return $opt;
    }

    /**
     * Get the ticket data
     * 
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTicket(Ticket $ticket)
    {
        $ticket = Ticket::where('id', $ticket->id)->with(['employee', 'category', 'technician', 'ticket_status'])->first();

        return response()->json($ticket);
    }

    /**
     * Get the User data
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getUser(User $user)
    {
        $user = User::find($user->id);

        return response()->json($user);
    }
}
