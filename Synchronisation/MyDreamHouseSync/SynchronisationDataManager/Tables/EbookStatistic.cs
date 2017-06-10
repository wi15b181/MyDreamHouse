﻿using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    class EbookStatistic : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into ebook_statistic (statistik_id,statistik_typ,benutzer_id,ebook_id) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, false);
            query = AddParam(query, row, 2, DataType.NUMERIC, false);           
            query = AddParam(query, row, 3, DataType.NUMERIC, true);

            return query;
        }
    }
}
