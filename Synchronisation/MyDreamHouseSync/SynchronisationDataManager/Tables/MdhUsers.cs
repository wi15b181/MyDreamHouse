using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    class MdhUsers : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into mdh_users (id,name,username,email,password) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, false);
            query = AddParam(query, row, 2, DataType.STRING, false);
            query = AddParam(query, row, 3, DataType.STRING, false);
            query = AddParam(query, row, 4, DataType.STRING, true);

            return query;
        }
    }
}
