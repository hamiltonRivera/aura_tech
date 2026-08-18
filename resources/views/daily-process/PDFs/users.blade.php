
    <div style="font-family: Arial, sans-serif; margin: 20px;">
          <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead class="table-thead">
                <tr style="background-color: #2d3748; color: white;">
                    <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;">#</th>
                    <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;"><i class="fa-solid fa-user"></i> Nombre</th>
                     <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;"><i class="fa-solid fa-envelope"></i> Correo</th>
                     <th style="padding: 12px; border: 1px solid #e2e8f0; text-align: center; font-size: 12px;"><i class="fa-solid fa-check-double"></i> Rol Actual</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($records as $user)
                <tr style="background-color: {{ $loop->even ? '#f7fafc' : 'white' }};">
                    <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $loop->iteration }} </td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $user->name }}</td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">{{ $user->email }}</td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; font-size: 12px; color: #4a5568; text-align: center;">
                        @if($user->roles->isNotEmpty())
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-1"></i>
                            {{ $user->roles->first()->name }}
                        </div>
                    @else
                        <div class="flex items-center">
                            <i class="fas fa-times text-red-500 mr-1"></i>
                            Sin Rol
                        </div>
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
          </table>
    </div>
